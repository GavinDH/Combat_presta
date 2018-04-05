<?php

if (!defined('_PS_VERSION_'))
    exit;

class workplace extends Module
{



    public function __construct()
    {
        $this->name = 'workplace';
        $this->version = '1.0';
        $this->author = 'Gavin den Hollander';
        $this->tab = 'administration';
        $this->secure_key = Tools::encrypt($this->name);
        $this->need_instance = 0;
        $this->controller = ['all'];
        $this->bootstrap = true;

        parent::__construct();
 
        $this->displayName = 'Workplace Lite';
        $this->description = $this->l('Easy to use workplace manager, do you use your ');
        $this->ps_versions_compliancy = [
            'min' => '1.7.2.0',
            'max' => _PS_VERSION_
        ];
 
        $this->confirmUninstall = $this->l('Are you sure you want to uninstall? Uninstalling this module will result in the lost of saved information in this module! the whole database needed for this module will be removed. if you ever want to use the module again please consider deactivating it!');
 
        if (!Configuration::get('workplace')) {
            $this->warning = $this->l('No name provided');
        }
   
    }

    public function install()
    {
        

        if (parent::install()  && $this->createTABLE() && $this->installModuleTab('WorkPlaceLite', array(1=>'Workplace Lite'), 0))
        { 
            $this->registerHook('displayBackOfficeHeader');
            return true;
        }
    }

    public function uninstall()
    {

        if ($this->dropTABLE() && $this->uninstallModuleTab('WorkPlaceLite') && !parent::uninstall()) {
            return false;
        }
        $this->unregisterHook('displayBackOfficeHeader');
        return true;
    }

    public function dropTABLE()
    {
        $sql= "DROP TABLE `"._DB_PREFIX_."module_workplace`; DROP TABLE `"._DB_PREFIX_."module_workplace_products`; DROP TABLE `"._DB_PREFIX_."module_workplace_log`;";

        if(!$result=Db::getInstance()->Execute($sql))
        {
            return false;
        }

        return true;
    }

    public function createTABLE()
    {
        $sql= "CREATE TABLE IF NOT EXISTS `"._DB_PREFIX_."module_workplace`(
            `project_id` INT(11) NOT NULL AUTO_INCREMENT PRIMARY KEY ,
            `discription` VARCHAR(256) NOT NULL,
            `name_worker` VARCHAR(100) NOT NULL,
            `customer_id` int(11) NOT NULL,
            `date_started` VARCHAR(15) NOT NULL,
            `end_date` VARCHAR(15) NOT NULL DEFAULT 'Undifend',
            `project_budget` VARCHAR(50) NOT NULL,
            `merk_replica` VARCHAR(50) NOT NULL,
            `model_replica` VARCHAR(50) NOT NULL,
            `problem_replica` VARCHAR(256) NOT NULL,
            `included_replica` VARCHAR(256) NOT NULL,
            `done` INT(1) NOT NULL DEFAULT '0',
            `phone` VARCHAR(14) NOT NULL
        );

        CREATE TABLE IF NOT EXISTS `"._DB_PREFIX_."module_workplace_products`( 
            `id_project_item` INT(11) NOT NULL AUTO_INCREMENT PRIMARY KEY ,
            `product_id` INT(11) NOT NULL , 
            `project_id` INT(11) NOT NULL , 
            `paid` INT(1) NOT NULL DEFAULT '0');

            CREATE TABLE IF NOT EXISTS `"._DB_PREFIX_."module_workplace_log`( 
            `id` INT(11) NOT NULL AUTO_INCREMENT PRIMARY KEY ,
            `project_id` INT(11) NOT NULL , 
            `text` TEXT);";

        if(!$result=Db::getInstance()->Execute($sql))
        {
            return false;
        }

        return true;
    }


    private function installModuleTab($tabClass, $tabName, $idTabParent)
    {    
         // Install Tabs
        $parent_tab = new Tab();
        // Need a foreach for the language
        $parent_tab->name[$this->context->language->id] = $this->l('WorkPlace Lite');
        $parent_tab->class_name = 'AdminWorkPlace';
        $parent_tab->id_parent = 0; // Home tab
        $parent_tab->module = $this->name;
        $parent_tab->add();



        $tabs = [['Workplace','AdminWorkplaceAll']];

        foreach ($tabs as &$value) {
            $tab = new Tab();
            $tab->name[$this->context->language->id] = $this->l($value[0]);
            $tab->class_name = $value[1];
            $tab->id_parent = $parent_tab->id;
            $tab->module = $this->name;
            $tab->add();
        }
        

        return true;
    }

    private function uninstallModuleTab($tabClass)
    {       
        $moduleTabs = Tab::getCollectionFromModule($this->name);
        if (!empty($moduleTabs)) {
            foreach ($moduleTabs as $moduleTab) {
                $moduleTab->delete();
            }
        }
        return true;
    }

    public function hookDisplayBackOfficeHeader() {
        $this->context->controller->addCss($this->_path.'css/tab.css');
    }

}

