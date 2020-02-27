<?php
namespace App\Controller;

/**
 * Class SuperGlobalsController
 * @package App\Controller
 */
abstract class SuperGlobalsController
{
    /**
     * @var mixed
     */
    protected $get = null;

    /**
     * @var mixed
     */
    protected $post = null;

    /**
     * @var mixed|null
     */
    protected $session = null;

    /**
     * @var mixed
     */
    protected $user = null;

    /**
     * @var
     */
    protected $files;

    /**
     * @var
     */
    protected $file;

    /**
     * SuperGlobalsController constructor
     */
    public function __construct()
    {
        $this->get      = filter_input_array(INPUT_GET);
        $this->post     = filter_input_array(INPUT_POST);

        $this->session = filter_var_array($_SESSION);
        if (isset($this->session['users']))
        {
            $this->user = $this->session['users'];
        }

        $this->files = filter_var_array($_FILES);
        if (isset($this->files['file'])) {
            $this->file = $this->files['file'];
        }
    }

    /**
     * getPostVar
     *
     * @param  mixed $id
     *
     * @return void
     */
    public function getPostVar($id)
    {
        return filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);
    }

    /**
     * @param array $data
     */
    public function sessionCreate(array $data)
    {
        $_SESSION['users'] = $data;
    }

    /**
     * @return void
     */
    public function sessionDestroy()
    {
        $_SESSION['users'] = [];
    }

    /**
     * @return bool
     */
    public function isLogged()
    {
        if (array_key_exists('users', $this->session)) {
            if (!empty($this->user)) {
                return true;
            }
        }
        return false;
    }

    /**
     * @param $var
     * @return mixed
     */
    public function getUserVar($var)
    {
        if ($this->isLogged() === false) {
            $this->user[$var] = null;
        }
        return $this->user[$var];
    }

    /**
     * @return mixed
     */
    public function getFilesArray()
    {
        return $this->files;
    }

    /**
     * @return mixed
     */
    public function getFileArray()
    {
        return $this->file;
    }

    /**
     * @param string $var
     * @return mixed
     */
    public function getFileVar(string $var)
    {
        return $this->file[$var];
    }

    /**
     * @param $fileDir
     * @return mixed
     */
    public function uploadFile(string $fileDir)
    {
        try {
            if (!isset($this->file['error']) || is_array($this->file['error'])) {
                throw new Exception('Invalid parameters...');
            }
            if ($this->file['size'] > 1000000) {
                throw new Exception('Exceeded filesize limit...');
            }
            if (!move_uploaded_file($this->file['tmp_name'], "{$fileDir}/{$this->file['name']}")) {
                throw new Exception('Failed to move uploaded file...');
            }
            return $this->file['name'];
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }
}