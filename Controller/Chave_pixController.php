<?php

namespace APINEW2\Chave_pix;

use APINEW2\Controller\Controller;
use APINEW2\Model\Chave_pixModel;
use Exception;

    include 'Controller.php';

    class Chave_pixController extends Controller
    {
        public static function Getid(): void
        {
          try
          {
            $id = $_GET['id'];

            $model = new Chave_pixModel();
            $model->Getid($id);
            parent::GetExcepitionAsJSON($model->rows);
          }  
          catch (Exception $e)
          {
            parent::GetExcepitionAsJSON($e);
         }  
        }    
    }