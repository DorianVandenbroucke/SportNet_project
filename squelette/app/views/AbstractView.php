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


    /*
     *  Crée le fragment HTML de l'entête
     *
     */
    protected function renderHeader(){
        $html ='<div>Sport<span>Net</span></div>';
        return $html;
    }

    /*
     * Crée le fragment HTML du bas de la page
     *
     */
    protected function renderFooter(){
        $html = 'SportNet &copy; 2016';
        return $html;
    }


    protected function renderMenu(){

        $path = "";
        $path_param = "";
        if (isset($_SERVER["PATH_INFO"])) {
            $path = $_SERVER["PATH_INFO"];
            if($_SERVER["QUERY_STRING"]){
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
              "" => "Accueil",
              "/event/all/" => "Evénements",
              "/event/add/" => "Ajouter un événement",
              "/event/all/?id=$id_promoter" => "Mes événements",
              "/logout/" => "Me déconnecter"
            );
        }else if(!isset($_SESSION['promoter'])){
            $array = array(
              "" => "Accueil",
              "/event/all/" => "Evénements",
              "/event/add/" => "Ajouter un événement",
              "/signin/" => "Me connecter"
            );
        }

        foreach($array as $lien => $nom){
          if($lien === $path){
            $html .=
                    "<li>
                        <a href='$this->script_name".$lien."' class='active'>".$nom."</a>
                    </li>";
          }else{
            $html .=
                    "<li>
                        <a href='$this->script_name".$lien."'>".$nom."</a>
                    </li>";
          }
        }

        $html .= "</ul>";
        return $html;

    }


    /*
     * Affiche une page HTML complète.
     *
     * A definir dans les classe concrètes
     *
     */
    abstract public function render($selector);



}
