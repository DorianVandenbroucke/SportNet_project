<?php

namespace app\views;

use app\utils\HttpRequest as HttpRequest;

abstract class AbstractView {


    protected $app_root = null;
    protected $script_name = null;
    protected $data = null ;

    public function __construct($data){
        $this->data = $data;

        $http = new HttpRequest();
        $this->script_name  = $http->script_name;
        $this->app_root     = $http->getRoot();
    }

    public function __get($attr_name) {
        if (property_exists( $this, $attr_name))
            return $this->$attr_name;
        $emess = __CLASS__ . ": unknown member $attr_name (__get)";
        throw new \Exception($emess);
    }

    public function __set($attr_name, $attr_val) {
        if (property_exists($this , $attr_name))
            $this->$attr_name=$attr_val;
        else{
            $emess = __CLASS__ . ": unknown member $attr_name (__set)";
            throw new \Exception($emess);
        }
    }

    public function __toString(){
        $prop = get_object_vars ($this);
        $str = "";
        foreach ($prop as $name => $val){
            if( !is_array($val) )
                $str .= "$name : $val <br> ";
            else
                $str .= "$name :". print_r($val, TRUE)."<br>";
        }
        return $str;
    }

    protected function renderHeader(){
        $html ='<div>Sport<span>Net</span></div>';
        return $html;
    }

    protected function renderFooter(){
        $html = '<div class="row">
			        <div class="offset_1 column_4">
				        <p>SportNet &copy; 2016</p>
				        <a href="#">Nous contacter</a>
                    </div>
			    </div>';
        return $html;
    }


    protected function renderMenu(){

        $path = "";
        $path_param = "";
        if (isset($_SERVER["PATH_INFO"])) {
            $path = $_SERVER["PATH_INFO"];
            if($_SERVER["QUERY_STRING"] && $path == "/event/all/" && (isset($_SESSION['promoter']) && $_SERVER['QUERY_STRING'] == "id=".$_SESSION['promoter'])){
                $path = $path."?".$_SERVER["QUERY_STRING"];
            }
        }

        $id_promoter = "";
        if (isset($_SESSION['promoter'])) {
            $id_promoter = $_SESSION['promoter'];
        }

        $html = '<ul class="navbar offset_1">';

        if (isset($_SESSION['promoter'])) {
            $array = array(
              "Accueil" => array("", "/", "/logout/"),
              "Evénements" => array("/event/all/", "/event/", "/activity/detail/", "/activity/register/", "/activity/participants/"),
              "Ajouter un événement" => array("/event/add/"),
              "Mes événements" => array("/event/all/?id=".$_SESSION['promoter']),
              "Me déconnecter" => array("/logout/")
            );
        }else if(!isset($_SESSION['promoter'])){
            $array = array(
              "Accueil" => array("", "/", "/logout/"),
              "Evénements" => array("/event/all/", "/event/", "/activity/detail/", "/activity/register/", "/activity/participants/"),
              "Ajouter un événement" => array("/event/add/"),
              "Me connecter" => array("/signin/")
            );
        }

        foreach($array as $nom => $liens){
          $verif_link = 0;
          $lien_o = $liens[0];
          foreach($liens as $lien){
            if($lien === $path){
              $html .=
                      "<li>
                          <a href='$this->script_name".$lien_o."' class='active'>".$nom."</a>
                      </li>";
              $verif_link = 1;
            }
          }
          if($verif_link == 0){
            $html .=
                    "<li>
                        <a href='$this->script_name".$lien_o."'>".$nom."</a>
                    </li>";
          }
        }

        $html .= "</ul>";
        return $html;

    }

    abstract public function render($selector);



}
