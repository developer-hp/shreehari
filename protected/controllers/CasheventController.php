<?php

class CasheventController extends Controller
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='//layouts/main';

	/**
	 * @return array action filters
	 */
	public function filters()
	{
		return array(
			'accessControl', // perform access control for CRUD operations
			'postOnly + delete', // we only allow deletion via POST request
		);
	}
	/**
	 * Specifies the access control rules.
	 * This method is used by the 'accessControl' filter.
	 * @return array access control rules
	 */
	public function accessRules()
	{
		return array(
			array('allow',  // allow all users to perform 'index' and 'view' actions
				'actions'=>array('index','view','view_event'),
				'users'=>array('@'),
			),
			array('allow', // allow authenticated user to perform 'create' and 'update' actions
				'actions'=>array('create','update','openpopup','open_sub_popup','add_new_cash','report','pdfexport','generate_excel','Generate_excel_new','findcustomer','list_supplier_event','list_customer_event','list_karigar_event' ,'delete_record','list_supplier_bill','list_customer_bill','list_karigar_bill','today_cash','today_gold','today_bank','today_card','today_discount','today_item','add_cash_supplier','add_cash_customer','add_cash_karigar','update_cash_supplier','update_cash_customer','update_cash_karigar','clear_account','printbill'),
				'users'=>array('@'),
			),
			array('allow', // allow admin user to perform 'admin' and 'delete' actions
				'actions'=>array('admin','delete','remove_record','print'),
				'users'=>array('@'),
			),
			array('deny',  // deny all users
				'users'=>array('*'),
			),
		);
	}

	public function actionPrintbill()
	{
		$id = $_GET['id'];

		$criteria=new CDbCriteria;
		$criteria->compare('customer_id',$id);
		$criteria->compare('is_deleted',0);
		$criteria->order = 'created_date asc,referral_code asc';

		// $cash_event = Cashevent::model()->findAllByAttributes(array('customer_id'=>$id,'is_deleted'=>0));
		$cash_event = Cashevent::model()->findAll($criteria);
		$customer = Customer::model()->findByPk($id);
		require_once(Yii::app()->basePath.'/../TCPDF-main/tcpdf.php');
		$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

		$pdf->SetCreator(PDF_CREATOR);
		$pdf->SetAuthor('Amcodr');
		$pdf->SetTitle($id);
		$pdf->SetSubject('TCPDF Tutorial');
		$pdf->SetKeywords('TCPDF, PDF, example, test, guide');

		// $pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE.' 049', PDF_HEADER_STRING);

		$pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
		$pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

		$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

		$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
		$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
		$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

		$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

		$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

		$pdf->SetFont('helvetica', '', 10);

		$pdf->AddPage();

		$ids = CHtml::listData($cash_event,'id','id');

		$criteria=new CDbCriteria;
		$criteria->compare('item_id','0');
		$criteria->addInCondition('cashevent_id',$ids);
		$criteria->order = 'cashevent_id asc';
		$cash_logs = Cashlogs::model()->findAll($criteria);
		// print "<pre>";
		// print_r($cash_logs); die;

		$html = $this->renderPartial('printbill', array('cash_event'=>$cash_event,'customer'=>$customer,'id'=>$id,'cash_logs'=>$cash_logs), true);
		$html .= '<style>'.file_get_contents(Yii::app()->basePath.'/../css/print.css').'</style>';

		$pdf->writeHTML($html);
		$pdf->Output($id.'.pdf', 'I');
	}


	public function actionClear_account()
	{
		$clear_accont_id=$_POST['clear_accont_id'];
		// echo $clear_accont_id;

		$cashevent_model = Cashevent::model()->findAllByAttributes(array('customer_id'=>$clear_accont_id,'is_deleted'=>0));
		foreach ($cashevent_model as $key => $value)
		{
			$cashlog_model = Cashlogs::model()->findAllByAttributes(array('cashevent_id'=>$value->id));
			foreach ($cashlog_model as $key => $value_cashlog)
			{
				 $value_cashlog->delete();
			}
			$value->is_deleted = 1;
			$value->save(false);
		}

		// pr($cashlog_model);
		die;
	}


	public function actionToday_cash()
	{
		$model=new Cashlogs('search_cash_today');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Cashlogs']))
			$model->attributes=$_GET['Cashlogs'];

		$this->render('cash_today',array(
			'model'=>$model,
		));
	}

	public function actionToday_gold()
	{
		$model=new Cashlogs('search_cash_today');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Cashlogs']))
			$model->attributes=$_GET['Cashlogs'];

		$this->render('cash_today',array(
			'model'=>$model,
		));
	}

	public function actionToday_bank()
	{
		$model=new Cashlogs('search_cash_today');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Cashlogs']))
			$model->attributes=$_GET['Cashlogs'];

		$this->render('cash_today',array(
			'model'=>$model,
		));
	}

	public function actionToday_card()
	{
		$model=new Cashlogs('search_cash_today');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Cashlogs']))
			$model->attributes=$_GET['Cashlogs'];

		$this->render('cash_today',array(
			'model'=>$model,
		));
	}

	public function actionToday_discount()
	{
		$model=new Cashlogs('search_cash_today');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Cashlogs']))
			$model->attributes=$_GET['Cashlogs'];

		$this->render('cash_today',array(
			'model'=>$model,
		));
	}

	public function actionToday_item()
	{
		$model=new Cashlogs('search_cash_today');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Cashlogs']))
			$model->attributes=$_GET['Cashlogs'];

		$this->render('cash_today',array(
			'model'=>$model,
		));
	}


	public function actionList_supplier_bill()
	{
		// redirect code
		$current_user=Yii::app()->user->id;
		Yii::app()->session['userView'.$current_user.'returnURL']=Yii::app()->request->Url;

		$model=new Cashevent('search_bill');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Cashevent']))
			$model->attributes=$_GET['Cashevent'];

		$this->render('cash_bill',array(
			'model'=>$model,
		));

	}

	public function actionList_customer_bill()
	{
		// redirect code
		$current_user=Yii::app()->user->id;
		Yii::app()->session['userView'.$current_user.'returnURL']=Yii::app()->request->Url;

		$model=new Cashevent('search_bill');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Cashevent']))
			$model->attributes=$_GET['Cashevent'];

		$this->render('cash_bill',array(
			'model'=>$model,
		));

	}

	public function actionList_karigar_bill()
	{
		// redirect code
		$current_user=Yii::app()->user->id;
		Yii::app()->session['userView'.$current_user.'returnURL']=Yii::app()->request->Url;

		$model=new Cashevent('search_bill');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Cashevent']))
			$model->attributes=$_GET['Cashevent'];

		$this->render('cash_bill',array(
			'model'=>$model,
		));

	}

	public function actionPdfexport()
	{
	/*	print_r($_GET['id']);
		die(); */
		$id = $_GET['id'];
		$this->layout =false;
		$model=Cashevent::model()->findByPk($id);
		$cash_lods = Cashlogs::model()->findAllByAttributes(array('cashevent_id'=>$id));

		PdfHelper::render(
			    'exportpdf',
			    array('model'=>$model,'cash_lods'=>$cash_lods),
			    'Report.pdf',
			    'I',
			    'A4',              // standard page size
			    [5, 5, 5, 5, 5, 5], // margins [left,right,top,bottom,header,footer]
			    'P',               // landscape
			    'gothic'       // custom font
			);

	}


	public function actionOpenpopup()
	{
		$model = new Cashevent;
		/* $selected_date = date("Y-m-d");
		 $model->created_date = date('d-m-Y',strtotime($selected_date)); */
			
		$model->scenario ='createrecord';
		if(isset($_POST['ajax']) && $_POST['ajax']==='cashevent-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
		$this->renderPartial('addcash', array('model'=>$model), false,true);
	}


	public function actionOpen_sub_popup()
	{

		

		$model=new Cashlogs('search_sub_item');
		$model->unsetAttributes(); 
		if(isset($_GET['Cashlogs']))
			$model->attributes=$_GET['Cashlogs'];

		$this->renderPartial('view_sub_item', array('model'=>$model), false,false);

		/* $this->render('admin',array(
			'model'=>$model,
		)); */
	}

	public function actionDelete_record()
	{
		$loginuser = User::model()->findByPk(Yii::app()->user->id);
		$delete_record = Cashlogs::model()->findByPk($_POST['cust_id']);
		if($loginuser->user_type==1)
		{
			$delete_record->delete();
		}
		if($loginuser->user_type==2)
		{
			$date = date('Y-m-d');
			if(isset($delete_record->check_date))
			{
				if($delete_record->check_date == $date)
				{
					$delete_record->delete();
				}
				else
				{
					$msg['msg'] = "you not allowd to delete this record......";
					echo json_encode($msg);
					die;
				}
			}
			else
			{
				$msg['msg'] = "you not allowd to delete this record......";
				echo json_encode($msg);
				die;
			}
		}
		die;
	}


	//not use
	public function actionList_supplier_event()
	{
		$model=new Cashlogs('search_event');
		$model->unsetAttributes(); 
		if(isset($_GET['Cashlogs']))
			$model->attributes=$_GET['Cashlogs'];

		$this->render('cash_event',array(
			'model'=>$model,
		));
	}

	//not use
	public function actionList_customer_event()
	{
		$model=new Cashlogs('search_event');
		$model->unsetAttributes();  
		if(isset($_GET['Cashlogs']))
			$model->attributes=$_GET['Cashlogs'];	
		$this->render('cash_event',array(
			'model'=>$model,
		));
	}

	//not use
	public function actionList_karigar_event()
	{
		$model=new Cashlogs('search_event');
		$model->unsetAttributes();  
		if(isset($_GET['Cashlogs']))
			$model->attributes=$_GET['Cashlogs'];

		$this->render('cash_event',array(
			'model'=>$model,
		));
	}

	/**
	 * Displays a particular model.
	 * @param integer $id the ID of the model to be displayed
	 */
	public function actionView($id)
	{
		$model = Cashlogs::model()->findByPk($id);
		$this->render('view',array(
			 'model'=>$model,
		));
	}

	public function actionView_event($id)
	{
		$model_log = new Cashlogs('search_cash');
		$model_log->unsetAttributes();  
		$model = Cashevent::model()->findByPk($id);
		$this->render('view_event',array(
			 'model'=>$model,'model_log'=>$model_log
		));
	}

	public function actionFindcustomer()
	{
		/* print_r($_POST);
			die(); */
		if(isset($_POST['searchTerm']))
		{	
			$is_deleted = 0;
			$user_data = $_POST['searchTerm'];
			$criteria=new CDbCriteria;
			$criteria->condition='name like "%'. $user_data .'%" and is_deleted ="'.$is_deleted.'" ';
			$criteria->order = 'name asc';
			$data = array();
			if($user_data != "")
			{
				$model=Customer::model()->findAll($criteria);
			}
			else
			{
				$model = "";
			}
			if($model)
			{	
				$data[] = array("id"=>"All","text"=>"All");
				foreach ($model as $key => $value)
				{
				  $data[] = array("id"=>$value['id'], "text"=>$value['name']);
				}
			}
			else
			{
				$data[] = array("id"=>"All","text"=>"All");
			}
			echo json_encode($data);
		}
	}

	/*public function actionFindcustomer()
	{
		$user_data = $_POST['user_data'];
		$model = Customer::model()->findAllByAttributes(array('type'=>$user_data));
		// print_r($model);
		//$output = "<option value=''>---Select Customer---</option>";
		$output = "<option value=''>---Select Customer---</option> <option value='all_cust'>All</option>";
		 foreach ($model as $key => $value) 
			 {
			 	$output .= '<option value="<?php $value->id; ?>">'.$value["name"].'</option>'; 
			 }

			   echo $output;

	}*/

	public function actionReport()
	{
		$this->render('report');
	}
	
	
	public function actionGenerate_excel_new()
	{
		// print_r($_POST);
		// die();
		$criteria=new CDbCriteria;
		$condition = "1=1";
		$sum_group = "";

		
		$criteria->join = 'JOIN cp_cash_event ON t.cashevent_id=cp_cash_event.id JOIN cp_customer ON t.customer_id=cp_customer.id';

		$condition.=' and  cp_cash_event.is_deleted=0 ';
		if(isset($_POST['user_type']) && $_POST['user_type'] != "")
		{
		 	$condition .= ' AND cp_customer.type ="'.$_POST['user_type'].'"  ';
		}

		if(isset($_POST['customer_id']) && $_POST['customer_id'] != "All")
		{
		 	$condition .= ' and t.customer_id ="'.$_POST['customer_id'].'"';
		}
		else
		{
		 	$sum_group = 1;
		}

		 if(isset($_POST['start_date']) && $_POST['start_date'] != "")
		 {
		 	 $new_date = date('Y-m-d',strtotime($_POST['start_date']));
		 	 $end_date = date('Y-m-d',strtotime($_POST['end_date']));
		 	$condition .= ' and t.date BETWEEN "'.$new_date.' 00:00:00" AND "'.$end_date.' 23:59:59 "';
		 }
		
		 $criteria->condition = $condition;
		 $criteria->order = 'cp_customer.name';
		 $models=Cashlogs::model()->findAll($criteria);

		 $customerNameArray = CHtml::listData(Customer::model()->findAll('is_deleted=0'),'id','name');


		$bold_rows = [];
		$number_format = [];

		$post_list = [];
	    $cash_total = 0;
	    $weight_total = 0;

	    foreach ($models as $value) {

	        $cash_total += $value->amount;

	        if (($value->amount == 0 && $value->type == 2) || $value->type != 2) {
	            $weight_total += $value->weight;
	        }

	        switch ($value->type) {
	            case 1: $payment_type = "Cash"; break;
	            case 2: $payment_type = "Gold"; break;
	            case 3: $payment_type = "Bank"; break;
	            case 4: $payment_type = "Card"; break;
	            case 5: $payment_type = "Discount"; break;
	            case 7: $payment_type = "Diamond"; break;
	            default: $payment_type = ""; break;
	        }

	        $main_amount = $value->amount;
	        $main_weight = $value->weight;

	        if ($sum_group != 1 && $value->amount != 0 && $value->type == 2) {
	            $main_weight = "";
	        }

	        $post_list[] = [
	            'Name'         => $customerNameArray[$value->customer_id] ?? '',
	            'Item_name'    => $value->note,
	            'Payment_type' => $payment_type,
	            'Amount'       => $main_amount,
	            'Total_amount' => $cash_total,
	            'Weight'       => $main_weight,
	            'Weight_Total' => $weight_total,
	            'Gross_Weight' => $value->gross_weight,
	            'Date'         => $value->date ? date('d-m-Y', strtotime($value->date)) : '',
	        ];
	    }

	    // pr($post_list);

	    /* =====================================================
	     * GROUPED EXPORT
	     * ===================================================== */
	    if ($sum_group == 1) {

	    	$number_format = ['E:G'=>'0.000'];

	        $headers = [
	            'CREDIT',
	            '',
	            '',
	            '',
	            '',
	            '',
	            '',
	        ];

	        $columnWidths = [30, 20, 20, 20, 20, 20, 20];

	        $customerArray = [];
	        $rows = [];

	        $bold_rows[] = 2;

	        $rows[] = [
	            'NAME',
	            'CREDIT TOTAL',
	            'DEBIT TOTAL',
	            'FINAL TOTAL',
	            'CREDIT METAL',
	            'DEBIT METAL',
	            'FINAL METAL',
	        ];

	        foreach ($models as $value) {
	            if (!isset($customerNameArray[$value->customer_id])) continue;

	            $weight = (!$value->amount && !$value->item_id) ? $value->weight : 0;

	            if (!isset($customerArray[$value->customer_id])) {
	                $customerArray[$value->customer_id] = [
	                    'name' => $customerNameArray[$value->customer_id],
	                    'credit_amount' => 0,
	                    'debit_amount' => 0,
	                    'credit_metal' => 0,
	                    'debit_metal' => 0,
	                ];
	            }

	            if ($value->amount > 0)
	                $customerArray[$value->customer_id]['credit_amount'] += $value->amount;
	            else
	                $customerArray[$value->customer_id]['debit_amount'] += $value->amount;

	            if ($weight > 0)
	                $customerArray[$value->customer_id]['credit_metal'] += $weight;
	            else
	                $customerArray[$value->customer_id]['debit_metal'] += $weight;
	        }

	        $credit = $debit = $creditMetal = $debitMetal = 0;

	        foreach ($customerArray as $post) {
	            if (($post['credit_amount'] + $post['debit_amount']) > 0) {
	                $rows[] = [
	                    $post['name'],
	                    $post['credit_amount'],
	                    $post['debit_amount'],
	                    $post['credit_amount'] + $post['debit_amount'],
	                    $post['credit_metal'],
	                    $post['debit_metal'],
	                    $post['credit_metal'] + $post['debit_metal'],
	                ];

	                $credit += $post['credit_amount'];
	                $debit += $post['debit_amount'];
	                $creditMetal += $post['credit_metal'];
	                $debitMetal += $post['debit_metal'];
	            }
	        }
	        $rows[] = [
	            'TOTAL CREDIT',
	            $credit,
	            $debit,
	            $credit + $debit,
	            $creditMetal,
	            $debitMetal,
	            $creditMetal + $debitMetal,
	        ];
	        $bold_rows[] = count($rows)+1;

	        $rows[] = [];
	        $rows[] = [
	            'DEBIT',
	        ];
	        $bold_rows[] = count($rows)+1;

	        $credit1 = $debit1 = $creditMetal1 = $debitMetal1 = 0;

	        foreach ($customerArray as $post) {
	            if (($post['credit_amount'] + $post['debit_amount']) <= 0) {
	                $rows[] = [
	                    $post['name'],
	                    $post['credit_amount'],
	                    $post['debit_amount'],
	                    $post['credit_amount'] + $post['debit_amount'],
	                    $post['credit_metal'],
	                    $post['debit_metal'],
	                    $post['credit_metal'] + $post['debit_metal'],
	                ];

	                $credit1 += $post['credit_amount'];
	                $debit1 += $post['debit_amount'];
	                $creditMetal1 += $post['credit_metal'];
	                $debitMetal1 += $post['debit_metal'];
	            }
	        }

	        $rows[] = [
	            'TOTAL DEBIT',
	            $credit1,
	            $debit1,
	            $credit1 + $debit1,
	            $creditMetal1,
	            $debitMetal1,
	            $creditMetal1 + $debitMetal1,
	        ];
	        $bold_rows[] = count($rows)+1;
	        $rows[] = [];
	        $rows[] = [
	            'FINAL TOTAL',
	            $credit,
	            $debit,
	            $credit + $debit,
	            $creditMetal,
	            $debitMetal,
	            $creditMetal + $debitMetal,
	        ];
	        $bold_rows[] = count($rows)+1;
	    }

	    /* =====================================================
	     * DETAILED EXPORT
	     * ===================================================== */
	    else {
	    	$number_format = ['F:H'=>'0.000'];

	        $headers = [
	            'NAME',
	            'ITEM NAME',
	            'PAYMENT TYPE',
	            'AMOUNT',
	            'TOTAL AMOUNT',
	            'METAL',
	            'TOTAL METAL',
	            'GROSS WEIGHT',
	            'DATE',
	        ];

	        $columnWidths = [30, 20, 15, 12, 15, 12, 15, 15, 12];

	        $rows = [];
	        foreach ($post_list as $post) {
	            $rows[] = [
	                $post['Name'],
	                $post['Item_name'],
	                $post['Payment_type'],
	                $post['Amount'],
	                $post['Total_amount'],
	                $post['Weight'],
	                $post['Weight_Total'],
	                $post['Gross_Weight'],
	                $post['Date'],
	            ];
	        }
	    }

	    /* =====================================================
	     * EXPORT
	     * ===================================================== */
	    ExcelHelper::export(
	        $headers,
	        $rows,
	        'Event_Report',
	        $columnWidths,
	        [
	            'bold_header' => true,
	            'auto_filter' => true,
	            'bold_rows'=>$bold_rows,
	            'number_format'=>$number_format
	        ]
	    );





	}


	public function actionAdd_cash_supplier()
	{
		$this->actionCreate();
	}

	public function actionAdd_cash_customer()
	{
		$this->actionCreate();
	}

	public function actionAdd_cash_karigar()
	{
		$this->actionCreate();
	}
	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */

	public function actionCreate()
	{
		$model=new Cashevent;
		$cash_log = new Cashlogs;

		// Uncomment the following line if AJAX validation is needed
		$model->scenario ='createrecord';
		$this->performAjaxValidation($model);

		if(isset($_POST['Cashevent']))
		{	
			/* pr($_POST);
			 die; */

			/* $check = Cashevent::model()->find(array('order'=>'id DESC'));	
			if(!empty($check))
			{
				$referral_code = $check->referral_code;
			}
			else
			{
				$referral_code = "INV00000";
			}			
			$num_value = str_replace("INV","",$referral_code);
			$start = 'INV';
			if(isset($check->referral_code) && $check->referral_code != "")
			{
				$num=$num_value+1;
			}
			else
			{
				$num = 1;
			}
			$model->referral_code = 'INV'.str_pad( $num, 5, "0", STR_PAD_LEFT ); */
			$model->referral_code = $_POST['Cashevent']['referral_code'];
			$model->created_date = date('Y-m-d',strtotime($_POST['Cashevent']['created_date']));
			$model->check_date = date('Y-m-d');
			$model->user_id = Yii::app()->user->getId();
			$model->customer_id = $_POST['Cashevent']['customer_id'];
			$model->narration = $_POST['Cashevent']['narration'];
			$model->main_note = $_POST['Cashevent']['main_note'];
			/* pr($_POST);
			die(); */

			if($model->save(false))
			{
				if(isset($_POST['note']) && $_POST['note'] != "")
				{
					foreach ($_POST['note'] as $key => $value)
					{
						$amount=0;
						$weight = "";
						$gross_weight = "";

						if ((!empty($_POST['amount'][$key])) || (!empty($_POST['weight'][$key])))
						{
							if(isset($_POST['amount'][$key]) && $_POST['amount'][$key]!='')
							{
								$amount = $_POST['amount'][$key];
							}
							if(isset($_POST['weight'][$key]) && $_POST['weight'][$key]!='')
							{
								$weight = $_POST['weight'][$key];
							}
							if(isset($_POST['gross_weight'][$key]) && $_POST['gross_weight'][$key]!='')
							{
								$gross_weight = $_POST['gross_weight'][$key];
							}
							$cash_log = new Cashlogs;
							$cash_log->cashevent_id = $model->id;
							$cash_log->customer_id = $_POST['Cashevent']['customer_id'];
							$cash_log->note = $value;
							$cash_log->item_id = 0;
							$cash_log->type = 6;
							$cash_log->amount = $amount;
							$cash_log->weight = $weight;
							$cash_log->gross_weight = $gross_weight;
							$cash_log->date = date('Y-m-d',strtotime($_POST['Cashevent']['created_date']));
							$cash_log->check_date = date('Y-m-d');
							$cash_log->status = 2;
							$cash_log->save(false);


							if(isset($_POST['sub_note'][$key]))
							{
								$sub_amount = 0;
								$sub_weight = "";
								foreach ($_POST['sub_note'][$key] as $key_sub => $value_sub)
								{
									$sub_amount = 0;
								    $sub_weight = "";
									if($_POST['sub_amount'][$key][$key_sub] !="" || $_POST['sub_weight'][$key][$key_sub])
								    {

										if(isset($_POST['sub_amount'][$key][$key_sub]) && $_POST['sub_amount'][$key][$key_sub]!='')
										{
											$sub_amount = $_POST['sub_amount'][$key][$key_sub];
										}
										if(isset($_POST['sub_weight'][$key][$key_sub]) && $_POST['sub_weight'][$key][$key_sub]!='')
										{
											$sub_weight = $_POST['sub_weight'][$key][$key_sub];
										}
										$cash_log_sub = new Cashlogs;
										$cash_log_sub->cashevent_id = $model->id;
										$cash_log_sub->customer_id = $_POST['Cashevent']['customer_id'];
										$cash_log_sub->note = $value_sub;
										$cash_log_sub->item_id = $cash_log->id;
										$cash_log_sub->type = 8;
										$cash_log_sub->amount = $sub_amount;
										$cash_log_sub->weight = $sub_weight;
										$cash_log_sub->date = date('Y-m-d',strtotime($_POST['Cashevent']['created_date']));
										$cash_log_sub->check_date = date('Y-m-d');
										$cash_log_sub->status = 2;
										$cash_log_sub->save(false);	
									}	

								}

							}

						}
					}
				}

				if(isset($_POST['cash_type']) && $_POST['cash_type'] != "")
				{
					foreach ($_POST['cash_type'] as $key => $value_cash_type)
					{
						$cash_amount=0;
						$cash_description="";

						if (!empty($_POST['cash_amount'][$key]))
						{
							if(isset($_POST['cash_amount'][$key]) && $_POST['cash_amount'][$key]!='')
							{
								$cash_amount = $_POST['cash_amount'][$key];
							}
							if(isset($_POST['cash_description'][$key]) && $_POST['cash_description'][$key]!='')
							{
								$cash_description = $_POST['cash_description'][$key];
							}

							$cash_log = new Cashlogs;
							$cash_log->cashevent_id = $model->id;
							$cash_log->customer_id = $_POST['Cashevent']['customer_id'];
							// $cash_log->note = $value;
							$cash_log->type = 1;
							$cash_log->amount = $cash_amount;
							$cash_log->description = $cash_description;
							$cash_log->date = date('Y-m-d',strtotime($_POST['Cashevent']['created_date']));
							$cash_log->check_date = date('Y-m-d');
							$cash_log->status = $value_cash_type;
							$cash_log->save(false);
						}
					}
				}

				if(isset($_POST['gold_type']) && $_POST['gold_type'] != "")
				{
					foreach ($_POST['gold_type'] as $key => $value_gold_type)
					{
						$gold_amount=0;
						$gold_description="";
						$gold_weight = "";
						$gross_gold_weight = "";

						if ((!empty($_POST['gold_amount'][$key])) || (!empty($_POST['gold_weight'][$key])))
						{
							if(isset($_POST['gold_amount'][$key]) && $_POST['gold_amount'][$key]!='')
							{
								$gold_amount = $_POST['gold_amount'][$key];
							}
							if(isset($_POST['gold_weight'][$key]) && $_POST['gold_weight'][$key]!='')
							{
								$gold_weight = $_POST['gold_weight'][$key];
							}
							if(isset($_POST['gross_gold_weight'][$key]) && $_POST['gross_gold_weight'][$key]!='')
							{
								$gross_gold_weight = $_POST['gross_gold_weight'][$key];
							}
							if(isset($_POST['gold_description'][$key]) && $_POST['gold_description'][$key]!='')
							{
								$gold_description = $_POST['gold_description'][$key];
							}
							$cash_log = new Cashlogs;
							$cash_log->cashevent_id = $model->id;
							$cash_log->customer_id = $_POST['Cashevent']['customer_id'];
							$cash_log->weight = $gold_weight;
							$cash_log->gross_weight = $gross_gold_weight;
							$cash_log->type = 2;
							$cash_log->amount = $gold_amount;
							$cash_log->description = $gold_description;
							$cash_log->date = date('Y-m-d',strtotime($_POST['Cashevent']['created_date']));
							$cash_log->check_date = date('Y-m-d');
							$cash_log->status = $value_gold_type;
							$cash_log->save(false);
						}
					}
				}

				if(isset($_POST['diamond_type']) && $_POST['diamond_type'] != "")
				{
					foreach ($_POST['diamond_type'] as $key => $value_diamond_type)
					{
						$diamond_amount=0;
						$diamond_description="";
						$diamond_weight = "";

						if ((!empty($_POST['diamond_amount'][$key])) || (!empty($_POST['diamond_weight'][$key])))
						{
							
							if(isset($_POST['diamond_amount'][$key]) && $_POST['diamond_amount'][$key]!='')
							{
								$diamond_amount = $_POST['diamond_amount'][$key];
							}
							if(isset($_POST['diamond_weight'][$key]) && $_POST['diamond_weight'][$key]!='')
							{
								$diamond_weight = $_POST['diamond_weight'][$key];
							}
							if(isset($_POST['diamond_description'][$key]) && $_POST['diamond_description'][$key]!='')
							{
								$diamond_description = $_POST['diamond_description'][$key];
							}
							$cash_log = new Cashlogs;
							$cash_log->cashevent_id = $model->id;
							$cash_log->customer_id = $_POST['Cashevent']['customer_id'];
							// $cash_log->note = $value;
							$cash_log->weight = $diamond_weight;
							$cash_log->type = 7;
							$cash_log->amount = $diamond_amount;
							$cash_log->description = $diamond_description;
							$cash_log->date = date('Y-m-d',strtotime($_POST['Cashevent']['created_date']));
							$cash_log->check_date = date('Y-m-d');
							$cash_log->status = $value_diamond_type;
							$cash_log->save(false);
						}

					}
				}

				if(isset($_POST['bank_type']) && $_POST['bank_type'] != "")
				{
					foreach ($_POST['bank_type'] as $key => $value_bank_type)
					{
						$bank_amount=0;
						$bank_description="";

						if(!empty($_POST['bank_amount'][$key]))
						{
							if(isset($_POST['bank_amount'][$key]) && $_POST['bank_amount'][$key]!='')
							{
								$bank_amount = $_POST['bank_amount'][$key];
							}
							if(isset($_POST['bank_description'][$key]) && $_POST['bank_description'][$key]!='')
							{
								$bank_description = $_POST['bank_description'][$key];
							}
							$cash_log = new Cashlogs;
							$cash_log->cashevent_id = $model->id;
							$cash_log->customer_id = $_POST['Cashevent']['customer_id'];
							$cash_log->type = 3;
							$cash_log->amount = $bank_amount;
							$cash_log->description = $bank_description;
							$cash_log->date = date('Y-m-d',strtotime($_POST['Cashevent']['created_date']));
							$cash_log->check_date = date('Y-m-d');
							$cash_log->status = $value_bank_type;
							$cash_log->save(false);
						}
					}
				}

				if(isset($_POST['card_type']) && $_POST['card_type'] != "")
				{
					foreach ($_POST['card_type'] as $key => $value_card_type)
					{
						$card_amount=0;
						$card_description="";

						if(!empty($_POST['card_amount'][$key]))
						{
							if(isset($_POST['card_amount'][$key]) && $_POST['card_amount'][$key]!='')
							{
								$card_amount = $_POST['card_amount'][$key];
							}
							if(isset($_POST['card_description'][$key]) && $_POST['card_description'][$key]!='')
							{
								$card_description = $_POST['card_description'][$key];
							}
							$cash_log = new Cashlogs;
							$cash_log->cashevent_id = $model->id;
							$cash_log->customer_id = $_POST['Cashevent']['customer_id'];
							$cash_log->type = 4;
							$cash_log->amount = $card_amount;
							$cash_log->description = $card_description;
							$cash_log->date = date('Y-m-d',strtotime($_POST['Cashevent']['created_date']));
							$cash_log->check_date = date('Y-m-d');
							$cash_log->status = $value_card_type;
							$cash_log->save(false);
						}
					}
				}

				if(isset($_POST['discount_type']) && $_POST['discount_type'] != "")
				{
					foreach ($_POST['discount_type'] as $key => $value_discount_type)
					{
						$discount_amount=0;
						$discount_description="";

						if(!empty($_POST['discount_amount'][$key]))
						{	
							if(isset($_POST['discount_amount'][$key]) && $_POST['discount_amount'][$key]!='')
							{	
								$discount_amount = $_POST['discount_amount'][$key];
							}	
							if(isset($_POST['discount_description'][$key]) && $_POST['discount_description'][$key]!='')
							{
								$discount_description = $_POST['discount_description'][$key];
							}
							$cash_log = new Cashlogs;
							$cash_log->cashevent_id = $model->id;
							$cash_log->customer_id = $_POST['Cashevent']['customer_id'];
							$cash_log->type = 5;
							$cash_log->amount = $discount_amount;
							$cash_log->description = $discount_description;
							$cash_log->date = date('Y-m-d',strtotime($_POST['Cashevent']['created_date']));
							$cash_log->check_date = date('Y-m-d');
							$cash_log->status = $value_discount_type;
							$cash_log->save(false);
						}
					}
				}
				
				if(isset($_POST['isAjaxRequest']) && $_POST['isAjaxRequest'] == 1) 
				{
				 	$msg['msg'] = "Cash Add Successfully......";
					echo json_encode($msg);
					die;
				}
				else
				{
					$redirect_model = Customer::model()->findByPk($model->customer_id);

					if($redirect_model->type == 1)
					{
						Yii::app()->user->setFlash('success', 'Insert successfully');
						if(isset($_POST['print']) && $_POST['print']=="Print")
						{
							$this->redirect(array('print','id'=>$model->id));
						}
						else
						$this->redirect(array('cashevent/list_supplier_bill','id'=>$_POST['Cashevent']['customer_id']));
					}
					if($redirect_model->type == 2)
					{
						Yii::app()->user->setFlash('success', 'Insert successfully');
						if(isset($_POST['print']) && $_POST['print']=="Print")
						{
							$this->redirect(array('print','id'=>$model->id));
						}
						else
						$this->redirect(array('cashevent/list_customer_bill','id'=>$_POST['Cashevent']['customer_id']));
					}
					if($redirect_model->type == 3)
					{
						Yii::app()->user->setFlash('success', 'Insert successfully');
						if(isset($_POST['print']) && $_POST['print']=="Print")
						{
							$this->redirect(array('print','id'=>$model->id));
						}
						else
						$this->redirect(array('cashevent/list_karigar_bill','id'=>$_POST['Cashevent']['customer_id']));
					}
					// Yii::app()->user->setFlash('success', 'Insert successfully');
					// $this->redirect(array('admin'));
					// $this->redirect(array('view','id'=>$model->id));
				}
					// Yii::app()->user->setFlash('success', 'Insert successfully');
					// $this->redirect(array('view','id'=>$model->id));
			}
		}

		$this->render('create',array(
			'model'=>$model,'cash_log'=>$cash_log
		));
	}
	/* function referral_code()
	{
		$chars = "0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ";
			$unique_number = "";
			for ($i = 0; $i < 10; $i++) {
			    $unique_number .= $chars[mt_rand(0, strlen($chars)-1)];
			}

	    // $unique_number = rand(100000, 999999);
	   	$exists=Cashevent::model()->findbyattributes(array("referral_code"=>$unique_number));
	    if ($exists){
	        $results =$this->referral_code();
	    }
	    else{
            $results = $unique_number;
	        return $results;
	     }
	} */

	/**
	 * Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id the ID of the model to be updated
	 */

	public function actionAdd_new_cash()
	{	
		/* echo "<pre>";	
		print_r($_POST);
		die; */
		$record_insrted = 0;
		$cust_id = Cashevent::model()->findByPk($_POST['Cashevent']['customer_id']);
	
				if(isset($_POST['cash_type']) && $_POST['cash_type'] != "")
				{
					foreach ($_POST['cash_type'] as $key => $value_cash_type)
					{
						if (!empty($_POST['cash_amount'][$key]))
						{
							$record_insrted = 1;
							$cash_amount=0;
							$cash_description="";
							if(isset($_POST['cash_amount'][$key]) && $_POST['cash_amount'][$key]!='')
							{
								$cash_amount = $_POST['cash_amount'][$key];
							}
							if(isset($_POST['cash_description'][$key]) && $_POST['cash_description'][$key]!='')
							{
								$cash_description = $_POST['cash_description'][$key];
							}
							$cash_log = new Cashlogs;
							$cash_log->cashevent_id = $_POST['Cashevent']['customer_id'];
							$cash_log->customer_id = $cust_id->customer_id;
							$cash_log->type = 1;
							$cash_log->amount = $cash_amount;
							$cash_log->description = $cash_description;
							$cash_log->date = date('Y-m-d',strtotime($_POST['Cashevent']['created_date']));
							$cash_log->check_date = date('Y-m-d');
							$cash_log->status = $value_cash_type;
							$cash_log->save(false);
						}
					}
				}

				if(isset($_POST['gold_type']) && $_POST['gold_type'] != "")
				{
					foreach ($_POST['gold_type'] as $key => $value_gold_type)
					{
						if ((!empty($_POST['gold_amount'][$key])) || (!empty($_POST['gold_weight'][$key])))
						{
							$record_insrted = 1;
							$gold_amount=0;
							$gold_description="";
							$gold_weight = "";
							$gross_gold_weight = "";
							if(isset($_POST['gold_amount'][$key]) && $_POST['gold_amount'][$key]!='')
							{
								$gold_amount = $_POST['gold_amount'][$key];
							}	
							if(isset($_POST['gold_weight'][$key]) && $_POST['gold_weight'][$key]!='')
							{
								$gold_weight = $_POST['gold_weight'][$key];
							}
							if(isset($_POST['gross_gold_weight'][$key]) && $_POST['gross_gold_weight'][$key]!='')
							{
								$gross_gold_weight = $_POST['gross_gold_weight'][$key];
							}
							if(isset($_POST['gold_description'][$key]) && $_POST['gold_description'][$key]!='')
							{
								$gold_description = $_POST['gold_description'][$key];
							}
							$cash_log = new Cashlogs;
							$cash_log->cashevent_id = $_POST['Cashevent']['customer_id'];
							$cash_log->customer_id = $cust_id->customer_id;
							$cash_log->type = 2;
							$cash_log->amount = $gold_amount;
							$cash_log->weight = $gold_weight;
							$cash_log->gross_weight = $gross_gold_weight;
							$cash_log->description = $gold_description;
							$cash_log->date = date('Y-m-d',strtotime($_POST['Cashevent']['created_date']));
							$cash_log->check_date = date('Y-m-d');
							$cash_log->status = $value_gold_type;
							$cash_log->save(false);
						}
					}
				}

				if(isset($_POST['diamond_type']) && $_POST['diamond_type'] != "")
				{
					foreach ($_POST['diamond_type'] as $key => $value_diamond_type)
					{
						if ((!empty($_POST['diamond_amount'][$key])) || (!empty($_POST['diamond_weight'][$key])))
						{
							$record_insrted = 1;
							$diamond_amount=0;
							$diamond_description="";
							$diamond_weight = "";
							if(isset($_POST['diamond_amount'][$key]) && $_POST['diamond_amount'][$key]!='')
							{
								$diamond_amount = $_POST['diamond_amount'][$key];
							}	
							if(isset($_POST['diamond_weight'][$key]) && $_POST['diamond_weight'][$key]!='')
							{
								$diamond_weight = $_POST['diamond_weight'][$key];
							}
							if(isset($_POST['diamond_description'][$key]) && $_POST['diamond_description'][$key]!='')
							{
								$diamond_description = $_POST['diamond_description'][$key];
							}
							$cash_log = new Cashlogs;
							$cash_log->cashevent_id = $_POST['Cashevent']['customer_id'];
							$cash_log->customer_id = $cust_id->customer_id;
							$cash_log->type = 7;
							$cash_log->amount = $diamond_amount;
							$cash_log->weight = $diamond_weight;
							$cash_log->description = $diamond_description;
							$cash_log->date = date('Y-m-d',strtotime($_POST['Cashevent']['created_date']));
							$cash_log->check_date = date('Y-m-d');
							$cash_log->status = $value_diamond_type;
							$cash_log->save(false);
						}
					}
				}		

				if(isset($_POST['bank_type']) && $_POST['bank_type'] != "")
				{
					foreach ($_POST['bank_type'] as $key => $value_bank_type)
					{
						if (!empty($_POST['bank_amount'][$key]))
						{
							$record_insrted = 1;
							$bank_amount=0;
							$bank_description="";
							if(isset($_POST['bank_amount'][$key]) && $_POST['bank_amount'][$key]!='')
							{
								$bank_amount = $_POST['bank_amount'][$key];
							}
							if(isset($_POST['bank_description'][$key]) && $_POST['bank_description'][$key]!='')
							{
								$bank_description = $_POST['bank_description'][$key];
							}
							$cash_log = new Cashlogs;
							$cash_log->cashevent_id = $_POST['Cashevent']['customer_id'];
							$cash_log->customer_id = $cust_id->customer_id;
							$cash_log->type = 3;
							$cash_log->amount = $bank_amount;
							$cash_log->description = $bank_description;
							$cash_log->date = date('Y-m-d',strtotime($_POST['Cashevent']['created_date']));
							$cash_log->check_date = date('Y-m-d');
							$cash_log->status = $value_bank_type;
							$cash_log->save(false);
						}
					}
				}

				if(isset($_POST['card_type']) && $_POST['card_type'] != "")
				{
					foreach ($_POST['card_type'] as $key => $value_card_type)
					{
						if (!empty($_POST['card_amount'][$key]))
						{
							$record_insrted = 1;
							$card_amount=0;
							$card_description="";
							if(isset($_POST['card_amount'][$key]) && $_POST['card_amount'][$key]!='')
							{
								$card_amount = $_POST['card_amount'][$key];
							}
							if(isset($_POST['card_description'][$key]) && $_POST['card_description'][$key]!='')
							{
								$card_description = $_POST['card_description'][$key];
							}
							$cash_log = new Cashlogs;
							$cash_log->cashevent_id = $_POST['Cashevent']['customer_id'];
							$cash_log->customer_id = $cust_id->customer_id;
							$cash_log->type = 4;
							$cash_log->amount = $card_amount;
							$cash_log->description = $card_description;
							$cash_log->date = date('Y-m-d',strtotime($_POST['Cashevent']['created_date']));
							$cash_log->check_date = date('Y-m-d');
							$cash_log->status = $value_card_type;
							$cash_log->save(false);
						}
					}
				}

				if(isset($_POST['discount_type']) && $_POST['discount_type'] != "")
				{
					foreach ($_POST['discount_type'] as $key => $value_discount_type)
					{
						if (!empty($_POST['discount_amount'][$key]))
						{
							$record_insrted = 1;
							$discount_amount=0;
							$discount_description="";
							if(isset($_POST['discount_amount'][$key]) && $_POST['discount_amount'][$key]!='')
							{
								$discount_amount = $_POST['discount_amount'][$key];
							}
							if(isset($_POST['discount_description'][$key]) && $_POST['discount_description'][$key]!='')
							{
								$discount_description = $_POST['discount_description'][$key];
							}
							$cash_log = new Cashlogs;
							$cash_log->cashevent_id = $_POST['Cashevent']['customer_id'];
							$cash_log->customer_id = $cust_id->customer_id;
							$cash_log->type = 5;
							$cash_log->amount = $discount_amount;
							$cash_log->description = $discount_description;
							$cash_log->date = date('Y-m-d',strtotime($_POST['Cashevent']['created_date']));
							$cash_log->check_date = date('Y-m-d');
							$cash_log->status = $value_discount_type;
							$cash_log->save(false);
						}
					}
				}

				if(isset($_POST['isAjaxRequest']) && $_POST['isAjaxRequest'] == 1) 
				{
					if($record_insrted == 0)
					{
						$msg['msg'] = "Record not inserted Successfully......";
						$msg['msg'] = 0;
						echo json_encode($msg);
						die;
					}
					 	$msg['msg'] = "Cash Add Successfully......";
						$msg['msg'] = 1;
						echo json_encode($msg);
						die;
				}
	}
	public function actionUpdate_cash_supplier()
	{
		$this->actionUpdate();
	}

	public function actionUpdate_cash_customer()
	{
		$this->actionUpdate();
	}

	public function actionUpdate_cash_karigar()
	{
		$this->actionUpdate();
	}
	public function actionPrint()
	{
		$id = $_GET['id'];
		$model=$this->loadModel($id);
		$cash_log_type = Cashlogs::model()->findAllByAttributes(array('cashevent_id'=>$id));
		$loginuser = User::model()->findByPk(Yii::app()->user->id);
		require_once(Yii::app()->basePath.'/../TCPDF-main/tcpdf.php');
		$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

		$pdf->SetCreator(PDF_CREATOR);
		$pdf->SetAuthor('Amcodr');
		$pdf->SetTitle($model->referral_code);
		$pdf->SetSubject('TCPDF Tutorial');
		$pdf->SetKeywords('TCPDF, PDF, example, test, guide');

		// $pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE.' 049', PDF_HEADER_STRING);

		$pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
		$pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

		$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

		$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
		$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
		$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

		$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

		$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

		$pdf->SetFont('helvetica', '', 10);

		$pdf->AddPage();
		$html = $this->renderPartial('print', array('model'=>$model,'cash_log_type'=>$cash_log_type), true);
		$html .= '<style>'.file_get_contents(Yii::app()->basePath.'/../css/print.css').'</style>';

		$pdf->writeHTML($html);
		$pdf->Output($model->referral_code.'.pdf', 'I');
	}

	public function actionUpdate()
	{
		$id = $_GET['id'];
		$model=$this->loadModel($id);
		$this->performAjaxValidation($model);
		$model->created_date = date('d-m-Y',strtotime($model->created_date));

		$cash_log_type = Cashlogs::model()->findAllByAttributes(array('cashevent_id'=>$id));
		
		// $this->performAjaxValidation($model);
		$loginuser = User::model()->findByPk(Yii::app()->user->id);
		
		if($loginuser->user_type==1 || $loginuser->user_type==2)
		{

			if(isset($_POST['Cashevent']))
			{
				// print_r($model->id);
				/* pr($_POST);
				   die();  */
				$model->referral_code = $_POST['Cashevent']['referral_code'];
				$model->created_date = date('Y-m-d',strtotime($_POST['Cashevent']['created_date']));
				$model->user_id = Yii::app()->user->getId();
				$model->customer_id = $_POST['Cashevent']['customer_id'];
				$model->narration = $_POST['Cashevent']['narration'];
				$model->main_note = $_POST['Cashevent']['main_note'];
				
				$date = date('Y-m-d');
				
				if($loginuser->user_type==2 && $model->check_date != $date)
				{
					Yii::app()->user->setFlash('danger', 'You not allowd update this record');
				    $this->redirect(array('admin'));
				}

				if($model->save(false))
				{
					if(isset($_POST['note']) && $_POST['note'] != "")
					{
						foreach ($_POST['note'] as $key => $value)
						{
							$amount=0;
							$weight = "";
							$gross_weight = "";
							if(isset($_POST['item_id'][$key]) && $_POST['item_id'][$key]!='')
							{
								// print_r($model->id);
								// die();
								$cash_log = Cashlogs::model()->findByPk($_POST['item_id'][$key]);

								if(isset($_POST['amount'][$key]) && $_POST['amount'][$key]!='')
								{
									$amount=$_POST['amount'][$key];
								}
								if(isset($_POST['weight'][$key]) && $_POST['weight'][$key]!='')
								{
									$weight = $_POST['weight'][$key];
								}
								if(isset($_POST['gross_weight'][$key]) && $_POST['gross_weight'][$key]!='')
								{
									$gross_weight = $_POST['gross_weight'][$key];
								}
								/* print_r($cash_log);
								die(); */
								$cash_log->cashevent_id = $model->id;
								$cash_log->customer_id = $_POST['Cashevent']['customer_id'];
								$cash_log->note = $value;
								$cash_log->type = 6;
								$cash_log->amount = $amount;
								$cash_log->weight = $weight;
								$cash_log->gross_weight = $gross_weight;
								$cash_log->status = 2;
								$cash_log->save(false);


							if(isset($_POST['sub_note'][$key]))
							{
								$sub_amount = 0;
								$sub_weight = "";
								foreach ($_POST['sub_note'][$key] as $key_sub => $value_sub)
								{
									$sub_amount = 0;
								    $sub_weight = "";
									if(isset($_POST['sub_item_id'][$key][$key_sub]))
									{

										$cash_log_sub = Cashlogs::model()->findByPk($_POST['sub_item_id'][$key][$key_sub]);
										
										if(!empty($cash_log_sub))
										{
											if(isset($_POST['sub_amount'][$key][$key_sub]) && $_POST['sub_amount'][$key][$key_sub]!='')
											{
												$sub_amount = $_POST['sub_amount'][$key][$key_sub];
											}
											if(isset($_POST['sub_weight'][$key][$key_sub]) && $_POST['sub_weight'][$key][$key_sub]!='')
											{
												$sub_weight = $_POST['sub_weight'][$key][$key_sub];
											}
											// $cash_log_sub = new Cashlogs;
											$cash_log_sub->cashevent_id = $model->id;
											$cash_log_sub->customer_id = $_POST['Cashevent']['customer_id'];
											$cash_log_sub->note = $value_sub;
											$cash_log_sub->item_id = $cash_log->id;
											$cash_log_sub->type = 8;
											$cash_log_sub->amount = $sub_amount;
											$cash_log_sub->weight = $sub_weight;
											$cash_log_sub->status = 2;
											$cash_log_sub->save(false);	
										}
									}
									else
									{
										if($_POST['sub_amount'][$key][$key_sub] !="" || $_POST['sub_weight'][$key][$key_sub])
										{
											/* $sub_amount = 0;
											$sub_weight = ""; */

											if(isset($_POST['sub_amount'][$key][$key_sub]) && $_POST['sub_amount'][$key][$key_sub]!='')
											{
												$sub_amount = $_POST['sub_amount'][$key][$key_sub];
											}
											if(isset($_POST['sub_weight'][$key][$key_sub]) && $_POST['sub_weight'][$key][$key_sub]!='')
											{
												$sub_weight = $_POST['sub_weight'][$key][$key_sub];
											}
											$cash_log_sub = new Cashlogs;
											$cash_log_sub->cashevent_id = $model->id;
											$cash_log_sub->customer_id = $_POST['Cashevent']['customer_id'];
											$cash_log_sub->note = $value_sub;
											$cash_log_sub->item_id = $cash_log->id;
											$cash_log_sub->type = 8;
											$cash_log_sub->amount = $sub_amount;
											$cash_log_sub->weight = $sub_weight;
											$cash_log_sub->date = date('Y-m-d');
											$cash_log_sub->check_date = date('Y-m-d');
											$cash_log_sub->status = 2;
											$cash_log_sub->save(false);	
										}

									}

								}

							}	

							}
							else
							{
								if ((!empty($_POST['amount'][$key])) || (!empty($_POST['weight'][$key])))
								{  
									if(isset($_POST['amount'][$key]) && $_POST['amount'][$key]!='')
									{
										$amount = $_POST['amount'][$key];
									}
									if(isset($_POST['weight'][$key]) && $_POST['weight'][$key]!='')
									{
										$weight = $_POST['weight'][$key];
									}
									if(isset($_POST['gross_weight'][$key]) && $_POST['gross_weight'][$key]!='')
									{
										$gross_weight = $_POST['gross_weight'][$key];
									}
									$cash_log = new Cashlogs;
									$cash_log->cashevent_id = $model->id;
									$cash_log->customer_id = $_POST['Cashevent']['customer_id'];
									$cash_log->note = $value;
									$cash_log->type = 6;
									$cash_log->amount = $amount;
									$cash_log->weight = $weight;
									$cash_log->gross_weight = $gross_weight;
									$cash_log->date = date('Y-m-d');
									$cash_log->check_date = date('Y-m-d');
									$cash_log->status = 2;
									$cash_log->save(false);
									if(isset($_POST['sub_note'][$key]))
									{
										$sub_amount = 0;
										$sub_weight = "";
										foreach ($_POST['sub_note'][$key] as $key_sub => $value_sub)
										{
											$sub_amount = 0;
										    $sub_weight = "";

											if($_POST['sub_amount'][$key][$key_sub] !="" || $_POST['sub_weight'][$key][$key_sub])
										    {

												if(isset($_POST['sub_amount'][$key][$key_sub]) && $_POST['sub_amount'][$key][$key_sub]!='')
												{
													$sub_amount = $_POST['sub_amount'][$key][$key_sub];
												}
												if(isset($_POST['sub_weight'][$key][$key_sub]) && $_POST['sub_weight'][$key][$key_sub]!='')
												{
													$sub_weight = $_POST['sub_weight'][$key][$key_sub];
												}
												$cash_log_sub = new Cashlogs;
												$cash_log_sub->cashevent_id = $model->id;
												$cash_log_sub->customer_id = $_POST['Cashevent']['customer_id'];
												$cash_log_sub->note = $value_sub;
												$cash_log_sub->item_id = $cash_log->id;
												$cash_log_sub->type = 8;
												$cash_log_sub->amount = $sub_amount;
												$cash_log_sub->weight = $sub_weight;
												$cash_log_sub->date = date('Y-m-d');
												$cash_log_sub->check_date = date('Y-m-d');
												$cash_log_sub->status = 2;
												$cash_log_sub->save(false);	
											}
										}
									}	
								}
							}
						}
					}

					if(isset($_POST['cash_type']) && $_POST['cash_type'] != "")
					{
						foreach ($_POST['cash_type'] as $key => $value_cash_type)
						{
							$cash_amount=0;
							$cash_description="";

							if(isset($_POST['cash_id'][$key]) && $_POST['cash_id'][$key]!='')
							{
								$cash_log = Cashlogs::model()->findByPk($_POST['cash_id'][$key]);
								if(isset($_POST['cash_amount'][$key]) && $_POST['cash_amount'][$key]!='')
								{
									$cash_amount = $_POST['cash_amount'][$key];
								}	
								if(isset($_POST['cash_description'][$key]) && $_POST['cash_description'][$key]!='')
								{
									$cash_description = $_POST['cash_description'][$key];
								}
								$cash_log->cashevent_id = $model->id;
								$cash_log->customer_id = $_POST['Cashevent']['customer_id'];
								$cash_log->type = 1;
								$cash_log->amount = $cash_amount;
								$cash_log->description = $cash_description;
								$cash_log->status = $value_cash_type;
								$cash_log->save(false);
							}
							else
							{
								if (!empty($_POST['cash_amount'][$key]))
								{
									if(isset($_POST['cash_amount'][$key]) && $_POST['cash_amount'][$key]!='')
									{
										$cash_amount = $_POST['cash_amount'][$key];
									}	
									if(isset($_POST['cash_description'][$key]) && $_POST['cash_description'][$key]!='')
									{
										$cash_description = $_POST['cash_description'][$key];
									}
									$cash_log = new Cashlogs;
									$cash_log->cashevent_id = $model->id;
									$cash_log->customer_id = $_POST['Cashevent']['customer_id'];
									$cash_log->type = 1;
									$cash_log->amount = $cash_amount;
									$cash_log->description = $cash_description;
									// $cash_log->date = date('Y-m-d',strtotime($_POST['Cashevent']['created_date']));
									$cash_log->date = date('Y-m-d');
									$cash_log->check_date = date('Y-m-d');
									$cash_log->status = $value_cash_type;
									$cash_log->save(false);
								}
							}
						}
					}

					if(isset($_POST['gold_type']) && $_POST['gold_type'] != "")
					{
						foreach ($_POST['gold_type'] as $key => $value_gold_type)
						{
							$gold_amount=0;
							$gold_description="";
							$gold_weight = "";
							$gross_gold_weight = "";

							if(isset($_POST['gold_id'][$key]) && $_POST['gold_id'][$key]!='')
							{
								$cash_log = Cashlogs::model()->findByPk($_POST['gold_id'][$key]);
								if(isset($_POST['gold_amount'][$key]) && $_POST['gold_amount'][$key]!='')
								{
									$gold_amount = $_POST['gold_amount'][$key];
								}
								if(isset($_POST['gold_weight'][$key]) && $_POST['gold_weight'][$key]!='')
								{
									$gold_weight = $_POST['gold_weight'][$key];
								}
								if(isset($_POST['gold_weight'][$key]) && $_POST['gold_weight'][$key]!='')
								{
									$gold_weight = $_POST['gold_weight'][$key];
								}
								if(isset($_POST['gross_gold_weight'][$key]) && $_POST['gross_gold_weight'][$key]!='')
								{
									$gross_gold_weight = $_POST['gross_gold_weight'][$key];
								}
								if(isset($_POST['gold_description'][$key]) && $_POST['gold_description'][$key]!='')
								{
									$gold_description = $_POST['gold_description'][$key];
								}
								$cash_log->cashevent_id = $model->id;
								$cash_log->customer_id = $_POST['Cashevent']['customer_id'];
								$cash_log->type = 2;
								$cash_log->weight = $gold_weight;
								$cash_log->gross_weight = $gross_gold_weight;
								$cash_log->amount = $gold_amount;
								$cash_log->description = $gold_description;
								// $cash_log->date = date('Y-m-d',strtotime($_POST['Cashevent']['created_date']));
								$cash_log->status = $value_gold_type;
								$cash_log->save(false);
							}
							else
							{
								if ((!empty($_POST['gold_amount'][$key])) || (!empty($_POST['gold_weight'][$key])))
								{
									if(isset($_POST['gold_amount'][$key]) && $_POST['gold_amount'][$key]!='')
									{
										$gold_amount = $_POST['gold_amount'][$key];
									}
									if(isset($_POST['gold_weight'][$key]) && $_POST['gold_weight'][$key]!='')
									{
										$gold_weight = $_POST['gold_weight'][$key];
									}
									if(isset($_POST['gross_gold_weight'][$key]) && $_POST['gross_gold_weight'][$key]!='')
									{
										$gross_gold_weight = $_POST['gross_gold_weight'][$key];
									}
									if(isset($_POST['gold_description'][$key]) && $_POST['gold_description'][$key]!='')
									{
										$gold_description = $_POST['gold_description'][$key];
									}
									$cash_log = new Cashlogs;
									$cash_log->cashevent_id = $model->id;
									$cash_log->customer_id = $_POST['Cashevent']['customer_id'];
									$cash_log->type = 2;
									$cash_log->weight = $gold_weight;
									$cash_log->gross_weight = $gross_gold_weight;
									$cash_log->amount = $gold_amount;
									$cash_log->description = $gold_description;
									// $cash_log->date = date('Y-m-d',strtotime($_POST['Cashevent']['created_date']));
									$cash_log->date = date('Y-m-d');
									$cash_log->check_date = date('Y-m-d');
									$cash_log->status = $value_gold_type;
									$cash_log->save(false);
								}
							}
						}
					}

					if(isset($_POST['diamond_type']) && $_POST['diamond_type'] != "")
					{
						foreach ($_POST['diamond_type'] as $key => $value_diamond_type)
						{
							$diamond_amount=0;
							$diamond_description="";
							$diamond_weight = "";

							if(isset($_POST['diamond_id'][$key]) && $_POST['diamond_id'][$key]!='')
							{
								$cash_log = Cashlogs::model()->findByPk($_POST['diamond_id'][$key]);
								if(isset($_POST['diamond_amount'][$key]) && $_POST['diamond_amount'][$key]!='')
								{
									$diamond_amount = $_POST['diamond_amount'][$key];
								}
								if(isset($_POST['diamond_weight'][$key]) && $_POST['diamond_weight'][$key]!='')
								{
									$diamond_weight = $_POST['diamond_weight'][$key];
								}
								if(isset($_POST['diamond_description'][$key]) && $_POST['diamond_description'][$key]!='')
								{
									$diamond_description = $_POST['diamond_description'][$key];
								}
								$cash_log->cashevent_id = $model->id;
								$cash_log->customer_id = $_POST['Cashevent']['customer_id'];
								$cash_log->type = 7;
								$cash_log->weight = $diamond_weight;
								$cash_log->amount = $diamond_amount;
								$cash_log->description = $diamond_description;
								// $cash_log->date = date('Y-m-d',strtotime($_POST['Cashevent']['created_date']));
								$cash_log->status = $value_diamond_type;
								$cash_log->save(false);


							}
							else
							{
								if ((!empty($_POST['diamond_amount'][$key])) || (!empty($_POST['diamond_weight'][$key])))
								{
									
									if(isset($_POST['diamond_amount'][$key]) && $_POST['diamond_amount'][$key]!='')
									{
										$diamond_amount = $_POST['diamond_amount'][$key];
									}
									if(isset($_POST['diamond_weight'][$key]) && $_POST['diamond_weight'][$key]!='')
									{
										$diamond_weight = $_POST['diamond_weight'][$key];
									}
									if(isset($_POST['diamond_description'][$key]) && $_POST['diamond_description'][$key]!='')
									{
										$diamond_description = $_POST['diamond_description'][$key];
									}
									$cash_log = new Cashlogs;
									$cash_log->cashevent_id = $model->id;
									$cash_log->customer_id = $_POST['Cashevent']['customer_id'];
									$cash_log->type = 7;
									$cash_log->weight = $diamond_weight;
									$cash_log->amount = $diamond_amount;
									$cash_log->description = $diamond_description;
									// $cash_log->date = date('Y-m-d',strtotime($_POST['Cashevent']['created_date']));
									$cash_log->date = date('Y-m-d');
									$cash_log->check_date = date('Y-m-d');
									$cash_log->status = $value_diamond_type;
									$cash_log->save(false);
								}
							}

						}
					}

					if(isset($_POST['bank_type']) && $_POST['bank_type'] != "")
					{
						foreach ($_POST['bank_type'] as $key => $value_bank_type)
						{
							$bank_amount=0;
							$bank_description="";
							if(isset($_POST['bank_id'][$key]) && $_POST['bank_id'][$key]!='')
							{
								$cash_log = Cashlogs::model()->findByPk($_POST['bank_id'][$key]);
								
								if(isset($_POST['bank_amount'][$key]) && $_POST['bank_amount'][$key]!='')
								{
									$bank_amount = $_POST['bank_amount'][$key];
								}
								if(isset($_POST['bank_description'][$key]) && $_POST['bank_description'][$key]!='')
								{
									$bank_description = $_POST['bank_description'][$key];
								}
								$cash_log->cashevent_id = $model->id;
								$cash_log->customer_id = $_POST['Cashevent']['customer_id'];
								$cash_log->type = 3;
								$cash_log->amount = $bank_amount;
								$cash_log->description = $bank_description;
								// $cash_log->date = date('Y-m-d',strtotime($_POST['Cashevent']['created_date']));
								$cash_log->status = $value_bank_type;
								$cash_log->save(false);
							}
							else
							{	
								if(!empty($_POST['bank_amount'][$key]))
								{ 
									
									if(isset($_POST['bank_amount'][$key]) && $_POST['bank_amount'][$key]!='')
									{
										$bank_amount = $_POST['bank_amount'][$key];
									}
									if(isset($_POST['bank_description'][$key]) && $_POST['bank_description'][$key]!='')
									{
										$bank_description = $_POST['bank_description'][$key];
									}
									$cash_log = new Cashlogs;
									$cash_log->cashevent_id = $model->id;
									$cash_log->customer_id = $_POST['Cashevent']['customer_id'];
									$cash_log->type = 3;
									$cash_log->amount = $bank_amount;
									$cash_log->description = $bank_description;
									// $cash_log->date = date('Y-m-d',strtotime($_POST['Cashevent']['created_date']));
									$cash_log->date = date('Y-m-d');
									$cash_log->check_date = date('Y-m-d');
									$cash_log->status = $value_bank_type;
									$cash_log->save(false);
								}
							}
						}
					}

					if(isset($_POST['card_type']) && $_POST['card_type'] != "")
					{
						foreach ($_POST['card_type'] as $key => $value_card_type)
						{
							$card_amount=0;
							$card_description="";
							if(isset($_POST['card_id'][$key]) && $_POST['card_id'][$key]!='')
							{
								$cash_log = Cashlogs::model()->findByPk($_POST['card_id'][$key]);
								
								if(isset($_POST['card_amount'][$key]) && $_POST['card_amount'][$key]!='')
								{
									$card_amount = $_POST['card_amount'][$key];
								}
								if(isset($_POST['card_description'][$key]) && $_POST['card_description'][$key]!='')
								{
									$card_description = $_POST['card_description'][$key];
								}
								$cash_log->cashevent_id = $model->id;
								$cash_log->customer_id = $_POST['Cashevent']['customer_id'];
								$cash_log->type = 4;
								$cash_log->amount = $card_amount;
								$cash_log->description = $card_description;
								// $cash_log->date = date('Y-m-d',strtotime($_POST['Cashevent']['created_date']));
								$cash_log->status = $value_card_type;
								$cash_log->save(false);
							}
							else
							{
								if(!empty($_POST['card_amount'][$key]))
								{ 
									if(isset($_POST['card_amount'][$key]) && $_POST['card_amount'][$key]!='')
									{
										$card_amount = $_POST['card_amount'][$key];
									}
									if(isset($_POST['card_description'][$key]) && $_POST['card_description'][$key]!='')
									{
										$card_description = $_POST['card_description'][$key];
									}
									$cash_log = new Cashlogs;
									$cash_log->cashevent_id = $model->id;
									$cash_log->customer_id = $_POST['Cashevent']['customer_id'];
									$cash_log->type = 4;
									$cash_log->amount = $card_amount;
									$cash_log->description = $card_description;
									// $cash_log->date = date('Y-m-d',strtotime($_POST['Cashevent']['created_date']));
									$cash_log->date = date('Y-m-d');
									$cash_log->check_date = date('Y-m-d');
									$cash_log->status = $value_card_type;
									$cash_log->save(false);
								}
							}
						}
					}


					if(isset($_POST['discount_type']) && $_POST['discount_type'] != "")
					{
						foreach ($_POST['discount_type'] as $key => $value_discount_type)
						{
							$discount_amount=0;
							$discount_description="";

							if(isset($_POST['dis_id'][$key]) && $_POST['dis_id'][$key]!='')
							{
								$cash_log = Cashlogs::model()->findByPk($_POST['dis_id'][$key]);
								if(isset($_POST['discount_amount'][$key]) && $_POST['discount_amount'][$key]!='')
								{
									$discount_amount = $_POST['discount_amount'][$key];
								}
								if(isset($_POST['discount_description'][$key]) && $_POST['discount_description'][$key]!='')
								{
									$discount_description = $_POST['discount_description'][$key];
								}
								$cash_log->cashevent_id = $model->id;
								$cash_log->customer_id = $_POST['Cashevent']['customer_id'];
								$cash_log->type = 5;
								$cash_log->amount = $discount_amount;
								$cash_log->description = $discount_description;
								// $cash_log->date = date('Y-m-d',strtotime($_POST['Cashevent']['created_date']));
								$cash_log->status = $value_discount_type;
								$cash_log->save(false);
							}
							else
							{
								if(!empty($_POST['discount_amount'][$key]))
								{ 
									if(isset($_POST['discount_amount'][$key]) && $_POST['discount_amount'][$key]!='')
									{
										$discount_amount = $_POST['discount_amount'][$key];
									}
									if(isset($_POST['discount_description'][$key]) && $_POST['discount_description'][$key]!='')
									{
										$discount_description = $_POST['discount_description'][$key];
									}
									$cash_log = new Cashlogs;
									$cash_log->cashevent_id = $model->id;
									$cash_log->customer_id = $_POST['Cashevent']['customer_id'];
									$cash_log->type = 5;
									$cash_log->amount = $discount_amount;
									$cash_log->description = $discount_description;
									// $cash_log->date = date('Y-m-d',strtotime($_POST['Cashevent']['created_date']));
									$cash_log->date = date('Y-m-d');
									$cash_log->check_date = date('Y-m-d');
									$cash_log->status = $value_discount_type;
									$cash_log->save(false);
								}
							}
						}
				}

				 $action_name = strtolower(Yii::app()->controller->action->id);
				 // print_r($_POST); die;
				 /* echo Yii::app()->request->urlReferrer;
				 die; */ 
				if($action_name == "update_cash_supplier")
				{
					Yii::app()->user->setFlash('success','Updated successfully');
					$current_user=Yii::app()->user->id;
					if(isset($_POST['print']) && $_POST['print']=="Print")
					{
						$this->redirect(array('print','id'=>$model->id));
					}
					else
					$this->redirect(Yii::app()->session['userView'.$current_user.'returnURL']);
					// $this->redirect(array('cashevent/list_supplier_bill','id'=>$_POST['Cashevent']['customer_id']));
				}
				else if($action_name == "update_cash_customer")
				{
					Yii::app()->user->setFlash('success','Updated successfully');
					$current_user=Yii::app()->user->id;
					if(isset($_POST['print']) && $_POST['print']=="Print")
					{
						$this->redirect(array('print','id'=>$model->id));
					}
					else
					$this->redirect(Yii::app()->session['userView'.$current_user.'returnURL']);
					// $this->redirect(array('cashevent/list_customer_bill','id'=>$_POST['Cashevent']['customer_id']));
				}
				else if($action_name == "update_cash_karigar")
				{
					Yii::app()->user->setFlash('success','Updated successfully');
					$current_user=Yii::app()->user->id;
					if(isset($_POST['print']) && $_POST['print']=="Print")
					{
						$this->redirect(array('print','id'=>$model->id));
					}
					else
					$this->redirect(Yii::app()->session['userView'.$current_user.'returnURL']);
					// $this->redirect(array('cashevent/list_karigar_bill','id'=>$_POST['Cashevent']['customer_id']));
				}
				else
				{
					// echo $model->customer_id;
					$redirect_model = Customer::model()->findByPk($model->customer_id);
					if($redirect_model->type == 1)
					{	
						Yii::app()->user->setFlash('success','Updated successfully');
						if(isset($_POST['print']) && $_POST['print']=="Print")
						{
							$this->redirect(array('print','id'=>$model->id));
						}
						else
						$this->redirect(array('cashevent/list_supplier_bill','id'=>$_POST['Cashevent']['customer_id']));
						// $current_user=Yii::app()->user->id;
						// $this->redirect(Yii::app()->session['userView'.$current_user.'returnURL']);
					}
					if($redirect_model->type == 2)
					{	
						Yii::app()->user->setFlash('success','Updated successfully');
						if(isset($_POST['print']) && $_POST['print']=="Print")
						{
							$this->redirect(array('print','id'=>$model->id));
						}
						else
						$this->redirect(array('cashevent/list_customer_bill','id'=>$_POST['Cashevent']['customer_id']));
						// $current_user=Yii::app()->user->id;
						// $this->redirect(Yii::app()->session['userView'.$current_user.'returnURL']);
					}
					if($redirect_model->type == 3)
					{	
						Yii::app()->user->setFlash('success','Updated successfully');
						if(isset($_POST['print']) && $_POST['print']=="Print")
						{
							$this->redirect(array('print','id'=>$model->id));
						}
						else
						$this->redirect(array('cashevent/list_karigar_bill','id'=>$_POST['Cashevent']['customer_id']));
						// $current_user=Yii::app()->user->id;
						// $this->redirect(Yii::app()->session['userView'.$current_user.'returnURL']);
					}
				}
				// $this->redirect(array('admin'));
			}
		}

		}
		$this->render('update',array(
			'model'=>$model,'cash_log_type'=>$cash_log_type
		));
	}

	/**
	 * Deletes a particular model.
	 * If deletion is successful, the browser will be redirected to the 'admin' page.
	 * @param integer $id the ID of the model to be deleted
	 */

	public function actionDelete($id)
	{
		/*echo $id;
		die;*/
		$model = Cashevent::model()->findByPk($id);
		$loginuser = User::model()->findByPk(Yii::app()->user->id);
		if($loginuser->user_type==1)
		{
			if($model)
			{
				Cashlogs::model()->deleteAll('cashevent_id = :cashevent_id', array(':cashevent_id'=>$id));
				$model->is_deleted = 1;
				$model->save(false);

			}
		}
		if($loginuser->user_type==2)
		{
			if($model)
			{
				$date = date('Y-m-d');
				if($model->check_date == $date)
				{
					Cashlogs::model()->deleteAll('cashevent_id = :cashevent_id', array(':cashevent_id'=>$id));
					$model->is_deleted = 1;
					$model->save(false);
				}
				else
				{
					Yii::app()->user->setFlash('danger', 'Updated not allowd this record');
				    $this->redirect(array('admin'));
				}
			}
		}
	}

	public function actionRemove_record()
    {
    	/* print_r($_POST);
    	die(); */
    	$loginuser = User::model()->findByPk(Yii::app()->user->id);
    	if($loginuser->user_type==1)
		{
	    	$delete_id = $_POST['delete_id'];
	    	$model = Cashlogs::model()->findByPk($delete_id);
	    	$model_all_delete = Cashlogs::model()->findAllByAttributes(array('item_id'=>$delete_id));
	    	foreach ($model_all_delete as $key => $value_delete_sub)
	    	{
	    		$value_delete_sub->delete();
	    	}
	    	   $model->delete(); 
	    }
	    if($loginuser->user_type==2)
		{
			
			$delete_id = $_POST['delete_id'];
			$date = date('Y-m-d');
	    	$model = Cashlogs::model()->findByPk($delete_id);
	    	if($model->check_date == $date)
	    	{
	    	   $model->delete(); 
	    	}
	    	
		}
    	echo 1;
    }

	/**
	 * Lists all models.
	*/
	public function actionIndex()
	{

		$model=new Cashevent('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Cashevent']))
			$model->attributes=$_GET['Cashevent'];

		$this->render('admin',array(
			'model'=>$model,
		));
		/* $dataProvider=new CActiveDataProvider('Cashevent');
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		)); */
	}
	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		// this is redirect code
		$current_user=Yii::app()->user->id;
		Yii::app()->session['userView'.$current_user.'returnURL']=Yii::app()->request->Url;

		$model=new Cashevent('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Cashevent']))
			$model->attributes=$_GET['Cashevent'];

		$this->render('admin',array(
			'model'=>$model,
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return Cashevent the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=Cashevent::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param Cashevent $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='cashevent-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
