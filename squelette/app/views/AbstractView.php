<?php

namespace app\views;

use app\utils\HttpRequest as HttpRequest;

abstract class AbstractView {


    protected $app_root = null;    /* répertoire racine de l'application */
    protected $script_name = null; /* le chemin vers le script */
    protected $data = null ;       /* une page ou un tableau de page */

    /* Constructeur
    *
    * Prend en paramète une variable (un objet page ou un tableau de page)
    *
    * - Stock la variable dans l'attribut $data
    * - Recupérer la racine de l'application depuis un objet HttpRequest,
    *   pour construire les URL des liens  et des actions des formulaire
    *   et le nom du scripte pour les stocker and les attributs
    *   $app_root et $script_name
    *
    */
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
        $html = '<ul class="navbar offset_1">';
        $html .= '<li><a href="'.$this->script_name.'" class="active">Accueil</a></li>';
        $html .= '<li><a href="'.$this->script_name.'/event/all/">Evenements</a></li>';
        $html .= '<li><a href="'.$this->script_name.'/event/add/">Ajouter un évenement</a></li>';
        if(isset($_SESSION['user_login'])){
        // TODO: URL A VOIR
            $html .= '<li><a href="'.$this->script_name.'/event/all/">Mes évenement</a></li>';
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
