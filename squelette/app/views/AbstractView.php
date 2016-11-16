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

        $path = $_SERVER["PATH_INFO"];
        $id_promoter= "";
        if (isset($_SESSION['promoter'])) {
            $id_promoter = $_SESSION['promoter'];
        }
        $html = '<ul class="navbar offset_1">';

        $array = array(
          "/" => "Accueil",
          "/event/all/" => "Evénements",
          "/event/add/" => "Ajouter un événement",
        );

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

        var_dump($array);
/*
        if ($path === "/") {

            $html .= '<li><a href="'.$this->script_name.'/" class="active">Accueil</a></li>';
            $html .= '<li><a href="'.$this->script_name.'/event/all/">Evenements</a></li>';
            $html .= '<li><a href="'.$this->script_name.'/event/add/">Ajouter un évenement</a></li>';
            if(isset($_SESSION['promoter'])){
              $html .= '<li><a href="'.$this->script_name.'/event/all/'.$_SESSION['promoter'].'">Mes évenement</a></li>';
              $html .= '<li><a href="'.$this->script_name.'/logout/">Me déconnecter</a></li>';
            }
        } elseif ($path === "/event/all/") {
            $html .= '<li><a href="'.$this->script_name.'/" >Accueil</a></li>';
            $html .= '<li><a href="'.$this->script_name.'/event/all/" class="active">Evenements</a></li>';
            $html .= '<li><a href="'.$this->script_name.'/event/add/">Ajouter un évenement</a></li>';
            if(isset($_SESSION['promoter'])){
              $html .= '<li><a href="'.$this->script_name.'/event/all/'.$_SESSION['promoter'].'">Mes évenement</a></li>';
              $html .= '<li><a href="'.$this->script_name.'/logout/">Me déconnecter</a></li>';
            }
        } elseif ($path === "/event/add/") {
            $html .= '<li><a href="'.$this->script_name.'/" >Accueil</a></li>';
            $html .= '<li><a href="'.$this->script_name.'/event/all/">Evenements</a></li>';
            $html .= '<li><a href="'.$this->script_name.'/event/add/" class="active">Ajouter un évenement</a></li>';
            if(isset($_SESSION['promoter'])){
              $html .= '<li><a href="'.$this->script_name.'/event/all/'.$_SESSION['promoter'].'">Mes évenement</a></li>';
              $html .= '<li><a href="'.$this->script_name.'/logout/">Me déconnecter</a></li>';
            }
        } elseif ($path === "/event/all/$id_promoter") {
            $html .= '<li><a href="'.$this->script_name.'/" >Accueil</a></li>';
            $html .= '<li><a href="'.$this->script_name.'/event/all/">Evenements</a></li>';
            $html .= '<li><a href="'.$this->script_name.'/event/add/">Ajouter un évenement</a></li>';
            if(isset($_SESSION['promoter'])){
              $html .= '<li><a href="'.$this->script_name.'/event/all/'.$_SESSION['promoter'].'" class="active" >Mes évenement</a></li>';
              $html .= '<li><a href="'.$this->script_name.'/logout/">Me déconnecter</a></li>';
            }
        } elseif ($path === "/logout/") {
            $html .= '<li><a href="'.$this->script_name.'/" class="active">Accueil</a></li>';
            $html .= '<li><a href="'.$this->script_name.'/event/all/">Evenements</a></li>';
            $html .= '<li><a href="'.$this->script_name.'/event/add/">Ajouter un évenement</a></li>';
        } else {
            $html .= '<li><a href="'.$this->script_name.'/" >Accueil</a></li>';
            $html .= '<li><a href="'.$this->script_name.'/event/all/">Evenements</a></li>';
            $html .= '<li><a href="'.$this->script_name.'/event/add/">Ajouter un évenement</a></li>';
            if(isset($_SESSION['promoter'])){
              $html .= '<li><a href="'.$this->script_name.'/event/all/'.$_SESSION['promoter'].'" class="active">Mes évenement</a></li>';
              $html .= '<li><a href="'.$this->script_name.'/logout/">Me déconnecter</a></li>';
            }
        }
*/
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
