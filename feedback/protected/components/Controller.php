<?php

/**
 * Controller is the customized base controller class.
 * All controller classes for this application should extend from this base class.
 */
class Controller extends CController {

    /**
     * @var string the default layout for the controller view. Defaults to '//layouts/column1',
     * meaning using a single column layout. See 'protected/views/layouts/column1.php'.
     */
    public $layout = '//layouts/column1';

    /**
     * @var array context menu items. This property will be assigned to {@link CMenu::items}.
     */
    public $menu = array();

    /**
     * @var array the breadcrumbs of the current page. The value of this property will
     * be assigned to {@link CBreadcrumbs::links}. Please refer to {@link CBreadcrumbs::links}
     * for more details on how to specify this property.
     */
    public $breadcrumbs = array();

    public function stateslist() {
        return CHtml::listData(State::model()->findAll('active=1 && deleted=0'), 'id', 'name');
    }
    public function countrylist() {
        return CHtml::listData(Country::model()->findAll('active=1 && deleted=0'), 'id', 'name');
    }
    public function accountstatuslist() {
        return CHtml::listData(AccountStatus::model()->findAll('active=1 && deleted=0'), 'id', 'name');
    }
    public function paymentprefslist() {
        return CHtml::listData(PaymentPrefs::model()->findAll('active=1 && deleted=0'), 'id', 'name');
    }
    public function employeelist() {
        return CHtml::listData(User::model()->findAll('active=1 && deleted=0 && user_type=2'), 'id', 'name');
    }
    public function accountlist() {
        return CHtml::listData(Account::model()->findAll('active=1 && deleted=0'), 'id', 'account_name');
    }
    public function jobtitlelist() {
        return CHtml::listData(JobTitle::model()->findAll('active=1 && deleted=0'), 'id', 'name');
    }
    public function servicelist() {
        return Service::model()->findAll('active=1 && deleted=0');
    }
    public function vendorlist() {
        return Vendor::model()->findAll('active=1 && deleted=0');
    }
    public function disbursmentlist() {
        return Disbursment::model()->findAll('active=1 && deleted=0');
    }
    public function contactlist($acc=0) {
        $str = '';
        if($acc)
            $str = ' and account_id='.$acc;
//        echo $str; die;
        return Contact::model()->findAll('active=1 && deleted=0'.$str);
    }

}
