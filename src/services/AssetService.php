<?php

namespace unionco\import\services;

use Craft;
use craft\base\Component;
use craft\elements\Asset;
use craft\fields\Assets as AssetsField;
use craft\helpers\Assets;
use Exception;
use unionco\import\Import;
use craft\db\Query;

class AssetService extends Component
{
    protected $fieldId = 117;
    protected $folderId = 6; // optional with fieldId and elementId
    protected $elementId = null;
    protected $query;
    protected $siteId;

    /**
     * 
     */
    public function orphanIds()
    {
        $this->query = new Query();
        $this->siteId = Craft::$app->getSites()->getCurrentSite()->id;

        $subQuery = new Query();
        $subQuery
            ->select('relations.targetId')
            ->from('{{%relations}} relations');
        
        $userSubQuery = new Query();
        $userSubQuery
            ->select('users.photoId')
            ->from('{{%users}} users');

        $this->query
            ->addSelect([
                'elementsId' => 'elements.id',
                'elementsSitesId' => 'elements_sites.id',
            ])
            ->from(['elements' => '{{%elements}}'])
            ->innerJoin('{{%elements_sites}} elements_sites', '[[elements_sites.elementId]] = [[elements.id]]')
            ->leftJoin('{{%relations}} relations', "[[relations.targetId]] = [[elements.id]]")
            ->where(['elements.type' => 'craft\\elements\\Asset'])
            ->andWhere(['not in', 'elements.id', $subQuery])
            // ->andWhere(['not in', 'elements.id', $userSubQuery])
            ->andWhere(['elements_sites.siteId' => $this->siteId]);
            // ->limit(100);
        
        $ids = array_map(function ($row) {
            return $row['elementsId'];
        }, $this->query->all());

        return $ids ?? [];
    }

    /**
     * 
     */
    public function save($folderId, $url)
    {
        $url = explode("?", $url)[0];
        
        try {
            $image = $this->importFile($url, $folderId);

            if (isset($image->assetId)) {
                return $image->assetId;
            }
        } catch (\Exception $e) {
            // die($e->getMessage());
        }
        return null;
    }

    public function importFile($url, $folderId)
    {
        // 
        $this->folderId = $folderId;

        // ensure remote file exists
        if (!$this->webFileExists($url)) {
            throw new Exception('Web File Does Not Exist');
        }

        // download remote file
        $fileName = Assets::prepareAssetName($url);
        $tempPath = Craft::$app->getPath()->getTempPath().DIRECTORY_SEPARATOR.$fileName;

        $this->save_remote_file($url, $tempPath);

        if (empty($this->folderId) && (empty($this->fieldId) || empty($this->elementId))) {
            throw new Exception('No target destination provided for uploading');
        }

        $assets = Craft::$app->getAssets();

        if (empty($this->folderId)) {
            $field = Craft::$app->getFields()->getFieldById((int)$this->fieldId);

            if (!($field instanceof AssetsField)) {
                throw new Exception('The field provided is not an Assets field');
            }

            $element = $this->elementId ? Craft::$app->getElements()->getElementById((int)$this->elementId) : null;
            $this->folderId = $field->resolveDynamicPathToFolderId($element);
        }

        if (empty($this->folderId)) {
            throw new Exception('The target destination provided for uploading is not valid');
        }

        $folder = $assets->findFolder(['id' => $this->folderId]);

        if (!$folder) {
            throw new Exception('The target folder provided for uploading is not valid');
        }

        $asset = new Asset();
        $asset->tempFilePath = $tempPath;
        $asset->filename = $fileName;
        $asset->newFolderId = $folder->id;
        $asset->volumeId = $folder->volumeId;
        $asset->avoidFilenameConflicts = true;
        $asset->setScenario(Asset::SCENARIO_REPLACE);

        try {
            $result = Craft::$app->getElements()->saveElement($asset);
        } catch(Exception $e) {
            return null;
        }

        // In case of error, let user know about it.
        if (!$result) {
            $errors = $asset->getFirstErrors();

            throw new Exception('Failed to save the Asset:' . implode(";\n", $errors));
        }

        if ($asset->conflictingFilename !== null) {
            $conflictingAsset = Asset::findOne(['folderId' => $folder->id, 'filename' => $asset->conflictingFilename]);

            return (object) [
                'conflict' => Craft::t('app', 'A file with the name “{filename}” already exists.', ['filename' => $asset->conflictingFilename]),
                'assetId' => $asset->id,
                'filename' => $asset->conflictingFilename,
                'conflictingAssetId' => $conflictingAsset ? $conflictingAsset->id : null
            ];
        }

        return (object) [
            'success' => true,
            'filename' => $asset->filename,
            'assetId' => $asset->id,
        ];
    }

    public function setElementId($elementId)
    {
        $this->elementId = $elementId;

        return $this;
    }

    public function setFieldId($fieldId)
    {
        $this->fieldId = $fieldId;

        return $this;
    }

    public function setFolderId($folderId)
    {
        $this->folderId = $folderId;

        return $this;
    }

    public function webFileExists($url)
    {
        $responseCode = $this->get_remote_headers($url);

        return $responseCode == 200;
    }

    public function get_remote_file($url)
    {
        $ch = curl_init($url);

        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_BINARYTRANSFER,1);

        $data = curl_exec ($ch);

        curl_close ($ch);

        return $data;
    }

    public function get_remote_headers($url)
    {
        $ch = curl_init();

        curl_setopt_array($ch, [
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_URL => $url,
        ]);

        curl_exec($ch);

        $responseCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

        curl_close($ch);

        return $responseCode;
    }

    public function save_remote_file($url, $localPath)
    {
        $ch = curl_init($url);

        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_BINARYTRANSFER, 1);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 2);

        $data = curl_exec($ch);

        curl_close ($ch);

        $fp = fopen($localPath, 'w');

        fwrite($fp, $data);
        fclose($fp);

        return true;
    }
}