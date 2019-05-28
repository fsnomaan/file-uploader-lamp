<?php
namespace fileUploader;

use fileUploader\Adapter;

class ApiController
{
    /** @var Adapter */
    private $dbAdapter;

    public function __construct($dbAdapter)
    {    
        $this->dbAdapter = $dbAdapter;
    }

    public function getListAction()
    {
        $files = $this->dbAdapter->getConnection()->query("SELECT id, name FROM files")->fetchAll(\PDO::FETCH_ASSOC);
        echo json_encode($files);
    }

    public function storeFileAction()
    {
        require_once 'views/upload.php';

        $fileName = $_FILES['newFile']['name'];

        if (!empty($_FILES)) {
            $fileName = $_FILES['newFile']['name'];
            $fileSize =$_FILES['newFile']['size'];
            $fileTempName  = $_FILES['newFile']['tmp_name'];
            $fileType=$_FILES['newFile']['type'];    
            $fileExt=strtolower(end(explode('.',$_FILES['newFile']['name'])));

            $sql = "INSERT INTO files (name, size, type, ext, path) Values (?, ?, ?, ?, ?)";
            $this->dbAdapter
                ->getConnection()
                ->prepare($sql)
                ->execute([
                    $fileName, 
                    $fileSize, 
                    $fileType, 
                    $fileExt, 
                    UPLOAD_PATH . '/' . $fileName
                ]);

            if ( is_uploaded_file($fileTempName) ) {
                move_uploaded_file($fileTempName, UPLOAD_PATH . '/' . $fileName);
            }
            echo "file upload successfully";
        }
    }

    public function getUsageAction()
    {
        $bytes = 0;
        foreach (glob(rtrim(UPLOAD_PATH, '/').'/*', GLOB_NOSORT) as $each) {
            $bytes += is_file($each) ? filesize($each) : folderSize($each);
        }

        $symbol = array('B', 'KiB', 'MiB', 'GiB', 'TiB', 'PiB', 'EiB', 'ZiB', 'YiB');
        $exp = floor(log($bytes)/log(1024));

        echo sprintf('%.2f '.$symbol[$exp], ($bytes/pow(1024, floor($exp))));
    }

    public function getDownloadAction($id)
    {
        $stmt = $this->dbAdapter->getConnection()->prepare("SELECT path FROM files WHERE id=?");
        $stmt->execute([$id]);
        $filePath = $stmt->fetchColumn();
        if ( empty($filePath) ) {
            die('No file found');
        }

        header('Content-Description: File Transfer');
        header('Content-Type: application/octet-stream');
        header('Content-Disposition: attachment; filename='.basename($filePath));
        header('Expires: 0');
        header('Cache-Control: must-revalidate');
        header('Pragma: public');
        header('Content-Length: ' . filesize($filePath));
        ob_clean();
        flush();
        readfile($filePath);
        exit;
    }

    public function deleteAction($id)
    {
        $stmt = $this->dbAdapter->getConnection()->prepare("DELETE FROM files WHERE id=?");
        $stmt->execute([$id]);
        echo 'deleted';
    }
}