<?php

class CustomerController extends Controller
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
				'actions'=>array('index','view_supllier','view_customer','view_karigar'),
				'users'=>array('@'),
			),
			array('allow', // allow authenticated user to perform 'create' and 'update' actions
				'actions'=>array('create','create_supplier','update_supplier','create_customer','create_karigar','update_customer','update_karigar','openpopup','save_cash_event','customer_popup','get_customer','get_type_customer','database_export','clear_without_backup','database_import'),
				'users'=>array('@'),
			),
			array('allow', // allow admin user to perform '	admin' and 'delete' actions
				'actions'=>array('list_supplier','delete','list_karigar','list_customer'),
				'users'=>array('@'),
			),
			array('deny',  // deny all users
				'users'=>array('*'),
			),
		);
	}

	public function actionDatabase_import()
	{
		/*echo "<pre>";
		print_r($_FILES);
		print_r($_POST);
		die();*/
		if(isset($_POST['hidden_id']))
		{
			$hidden_id = $_POST['hidden_id'];
			if($hidden_id == 3)
			{

				$loginuser = User::model()->findByPk(Yii::app()->user->id);
					if($loginuser->user_type == 1)
					{

						if (isset($_FILES['import_file']) && !empty($_FILES['import_file']))
						{

							$pro = $_FILES['import_file']['name'];
							$filename = md5(time().rand(0,9999));
							$ext = '';
							$uploads_dir = Yii::getPathOfAlias('webroot').'/uploads/';
							$ext = pathinfo($pro);
							$new_image = $filename.'.'.$ext['extension'];
							move_uploaded_file($_FILES['import_file']['tmp_name'],$uploads_dir.'/'.$new_image);


						  	$con = $connection=Yii::app()->db; 
							$command=$connection->createCommand($con);
							$backup_name = $new_image;
							$file_path = Yii::app()->basePath .'/../uploads/'.$backup_name;
							$sql = file_get_contents($file_path);
							try 
							{
								$sql = str_replace('"",','NULL,',$sql);
						        $success = Yii::app()->db->createCommand($sql)->execute();	       
						    }
						    catch(\Exception $e)
						    {
						    	echo $e->getMessage();
						    	echo "error"; die;
						    }
						    unlink($uploads_dir.$new_image);
						    Yii::app()->user->setFlash('success', 'Import  data successfully');
				        	$this->redirect(array('site/index'));

						}
					}
					else
					{
						Yii::app()->user->setFlash('danger', 'Invalid User');
		       			$this->redirect(array('site/index'));		
					}	
			}
			else
			{
				Yii::app()->user->setFlash('danger', 'You did something wrong');
		        $this->redirect(array('site/index'));
			}
		}
		else
		{
			Yii::app()->user->setFlash('danger', 'You did something wrong');
	        $this->redirect(array('site/index'));
		}

	}



	public function actionClear_without_backup()
	{

		if(isset($_POST['user_password']))
		{

			$hidden_id = $_POST['hidden_id'];
			if($hidden_id == 1)
			{

				$user_password = $_POST['user_password'];
				$loginuser = User::model()->findByPk(Yii::app()->user->id);
					if($loginuser->user_type == 1)
					{
						if(md5($user_password) == $loginuser->password)
						{
							// die("AAA");
							Customer::model()->deleteAll();
				        	Cashevent::model()->deleteAll();
				        	Cashlogs::model()->deleteAll();

							Yii::app()->user->setFlash('success', 'Clear all data successfully');
				        	$this->redirect(array('site/index'));
				    	}
				    	else
				    	{
				    		Yii::app()->user->setFlash('danger', 'Invalid Password');
				       		$this->redirect(array('site/index'));			
				    	}

				    }
				    else
				    {
				    	Yii::app()->user->setFlash('danger', 'Invalid User');
				        $this->redirect(array('site/index'));
				    }

				}
			    else
			    {
			    	Yii::app()->user->setFlash('danger', 'You did something wrong');
			        $this->redirect(array('site/index'));
			    }    

    	}
    	else
    	{
    		Yii::app()->user->setFlash('danger', 'Invalid Password');
       		$this->redirect(array('site/index'));	
    	}

	}


	public function actionDatabase_export()
	{
	 
		// print_r($_POST);
		if(isset($_POST['user_password']))
		{

			$hidden_id = $_POST['hidden_id'];
			if($hidden_id == 2)
			{	

			$user_password = $_POST['user_password'];
			$loginuser = User::model()->findByPk(Yii::app()->user->id);
				if($loginuser->user_type == 1)
				{
					if(md5($user_password) == $loginuser->password)
					{
				   		$sql = 'SHOW TABLES';
				        $tables = Yii::app()->db
				            ->createCommand($sql)
				            ->queryAll();
				            
				        $html="";
				        	foreach ($tables as $key => $value_table)
				        	{
				        		/*print_r($value_table);
				        		die();*/
				        		if($value_table['Tables_in_customer_ledger_db'] == 'cp_customer')
				        		{
				        			$tableName  = 'cp_customer';
				        			$model_customer = Customer::model()->findAll();
				        			
				        			foreach($model_customer as $key => $value_cust)
				        			{
				        				$html.= 'INSERT INTO '.$tableName.' VALUES(';

				        				$value_cust->id = addslashes($value_cust->id);
					                    // $value_cust->id = ereg_replace("\n","\n",$value_cust->id);

						                  	if (isset($value_cust->id))
						                  	{
						                    	$html.='"'.$value_cust->id.'",' ; 
						                    }
						                    else 
						                    {
						                       $html.='"",'; 
							                }

							            $value_cust->name = addslashes($value_cust->name);
					                    // $value_cust->name = ereg_replace("\n","\n",$value_cust->name);

						                  	if (isset($value_cust->name))
						                  	{
						                    	$html.='"'.$value_cust->name.'",' ; 
						                    }
						                    else 
						                    {
						                       $html.='"",'; 
							                }

							            $value_cust->mobile = addslashes($value_cust->mobile);
					                    // $value_cust->mobile = ereg_replace("\n","\n",$value_cust->mobile);

						                  	if (isset($value_cust->mobile))
						                  	{
						                    	$html.='"'.$value_cust->mobile.'",' ; 
						                    }
						                    else 
						                    {
						                       $html.='"",'; 
							                }

							            $value_cust->address = addslashes($value_cust->address);
					                    // $value_cust->address = ereg_replace("\n","\n",$value_cust->address);

						                  	if (isset($value_cust->address))
						                  	{
						                    	$html.='"'.$value_cust->address.'",' ; 
						                    }
						                    else 
						                    {
						                       $html.='"",'; 
							                } 
							             
							            $value_cust->type = addslashes($value_cust->type);
					                    // $value_cust->type = ereg_replace("\n","\n",$value_cust->type);

						                  	if (isset($value_cust->type))
						                  	{
						                    	$html.='"'.$value_cust->type.'",' ; 
						                    }
						                    else 
						                    {
						                       $html.='"",'; 
							                }  

							            $value_cust->is_deleted = addslashes($value_cust->is_deleted);
					                    // $value_cust->is_deleted = ereg_replace("\n","\n",$value_cust->is_deleted);

						                  	if (isset($value_cust->is_deleted))
						                  	{
						                    	$html.='"'.$value_cust->is_deleted.'"' ; 
						                    }
						                    else 
						                    {
						                       $html.='""'; 
							                }    
							                
							            $html.=");\n"; 

				        			}	

				        		}

				            	if($value_table['Tables_in_customer_ledger_db'] == 'cp_cash_event')
				            	{
				                   		$tableName  = 'cp_cash_event';
				                    	$model  = Cashevent::model()->findAll();

						                    foreach ($model as $key => $value_model)
							            	{     
						              			$html.= 'INSERT INTO '.$tableName.' VALUES(';

						                		$value_model->id = addslashes($value_model->id);
							                    // $value_model->id = ereg_replace("\n","\n",$value_model->id);

								                  	if (isset($value_model->id))
								                  	{
								                    	$html.='"'.$value_model->id.'",' ; 
								                    }
								                    else 
								                    {
								                       $html.='"",'; 
									                }

								                $value_model->user_id = addslashes($value_model->user_id);
							                    // $value_model->user_id = ereg_replace("\n","\n",$value_model->user_id);

									                if (isset($value_model->user_id))
								                  	{
								                    	$html.='"'.$value_model->user_id.'",' ; 
								                    }
								                    else 
								                    {
								                       $html.='"",'; 
									                }

									            $value_model->customer_id = addslashes($value_model->customer_id);
							                    // $value_model->customer_id = ereg_replace("\n","\n",$value_model->customer_id); 
							                       
									                if (isset($value_model->customer_id))
								                  	{
								                    	$html.='"'.$value_model->customer_id.'",' ; 
								                    }
								                    else 
								                    {
								                       $html.='"",'; 
									                }

									            $value_model->cash_type = addslashes($value_model->cash_type);
							                    // $value_model->cash_type = ereg_replace("\n","\n",$value_model->cash_type);
							                        
									                if (isset($value_model->cash_type))
								                  	{
								                    	$html.='"'.$value_model->cash_type.'",' ; 
								                    }
								                    else 
								                    {
								                       $html.='"",'; 
									                }

									            $value_model->amount = addslashes($value_model->amount);
							                    // $value_model->amount = ereg_replace("\n","\n",$value_model->amount);
							                        
									                if (isset($value_model->amount))
								                  	{
								                    	$html.='"'.$value_model->amount.'",' ; 
								                    }
								                    else 
								                    {
								                       $html.='"",'; 
									                }

									            $value_model->gold_type = addslashes($value_model->gold_type);
							                    // $value_model->gold_type = ereg_replace("\n","\n",$value_model->gold_type);
							                        
									                if (isset($value_model->gold_type))
								                  	{
								                    	$html.='"'.$value_model->gold_type.'",' ; 
								                    }
								                    else 
								                    {
								                       $html.='"",'; 
									                }

									            $value_model->gold_amount = addslashes($value_model->gold_amount);
							                    // $value_model->gold_amount = ereg_replace("\n","\n",$value_model->gold_amount);
							                        
									                if (isset($value_model->gold_amount))
								                  	{
								                    	$html.='"'.$value_model->gold_amount.'",' ; 
								                    }
								                    else 
								                    {
								                       $html.='"",'; 
									                }

									            $value_model->bank_type = addslashes($value_model->bank_type);
							                    // $value_model->bank_type = ereg_replace("\n","\n",$value_model->bank_type);
							                        
									                if (isset($value_model->bank_type))
								                  	{
								                    	$html.='"'.$value_model->bank_type.'",' ; 
								                    }
								                    else 
								                    {
								                       $html.='"",'; 
									                }

									            $value_model->bank_amount = addslashes($value_model->bank_amount);
							                    // $value_model->bank_amount = ereg_replace("\n","\n",$value_model->bank_amount);

									                if (isset($value_model->bank_amount))
								                  	{
								                    	$html.='"'.$value_model->bank_amount.'",' ; 
								                    }
								                    else 
								                    {
								                       $html.='"",'; 
									                }

									            $value_model->card_type = addslashes($value_model->card_type);
							                    // $value_model->card_type = ereg_replace("\n","\n",$value_model->card_type);  

									                if (isset($value_model->card_type))
								                  	{
								                    	$html.='"'.$value_model->card_type.'",' ; 
								                    }
								                    else 
								                    {
								                       $html.='"",'; 
									                }

									            $value_model->card_amount = addslashes($value_model->card_amount);
							                    // $value_model->card_amount = ereg_replace("\n","\n",$value_model->card_amount);
							                        
									                if (isset($value_model->card_amount))
								                  	{
								                    	$html.='"'.$value_model->card_amount.'",' ; 
								                    }
								                    else 
								                    {
								                       $html.='"",'; 
									                }

									            $value_model->discount_type = addslashes($value_model->discount_type);
							                    // $value_model->discount_type = ereg_replace("\n","\n",$value_model->discount_type);
							                        
									                if (isset($value_model->discount_type))
								                  	{
								                    	$html.='"'.$value_model->discount_type.'",' ; 
								                    }
								                    else 
								                    {
								                       $html.='"",'; 
									                }

									            $value_model->discount_amount = addslashes($value_model->discount_amount);
							                    // $value_model->discount_amount = ereg_replace("\n","\n",$value_model->discount_amount);

									                if (isset($value_model->discount_amount))
								                  	{
								                    	$html.='"'.$value_model->discount_amount.'",' ; 
								                    }
								                    else 
								                    {
								                       $html.='"",'; 
									                }

									            $value_model->narration = addslashes($value_model->narration);
							                    // $value_model->narration = ereg_replace("\n","\n",$value_model->narration);
							                        
									                if (isset($value_model->narration))
								                  	{
								                    	$html.='"'.$value_model->narration.'",' ; 
								                    }
								                    else 
								                    {
								                       $html.='"",'; 
									                }

									            $value_model->created_date = addslashes($value_model->created_date);
							                    // $value_model->created_date = ereg_replace("\n","\n",$value_model->created_date);
							                        
									                if (isset($value_model->created_date))
								                  	{
								                    	$html.='"'.$value_model->created_date.'",' ; 
								                    }
								                    else 
								                    {
								                       $html.='"",'; 
									                }

									            $value_model->check_date = addslashes($value_model->check_date);
							                    // $value_model->check_date = ereg_replace("\n","\n",$value_model->check_date);
							                        
									                if (isset($value_model->check_date))
								                  	{
								                    	$html.='"'.$value_model->check_date.'",' ; 
								                    }
								                    else 
								                    {
								                       $html.='"",'; 
									                }

								                $value_model->referral_code = addslashes($value_model->referral_code);
							                    // $value_model->referral_code = ereg_replace("\n","\n",$value_model->referral_code);

									                if (isset($value_model->referral_code))
								                  	{
								                    	$html.='"'.$value_model->referral_code.'",' ; 
								                    }
								                    else 
								                    {
								                       $html.='"",'; 
									                }


									            $value_model->main_note = addslashes($value_model->main_note);
							                    // $value_model->main_note = ereg_replace("\n","\n",$value_model->main_note);

									                if (isset($value_model->main_note))
								                  	{
								                    	$html.='"'.$value_model->main_note.'",' ; 
								                    }
								                    else 
								                    {
								                       $html.='"",'; 
									                }

									            $value_model->is_deleted = addslashes($value_model->is_deleted);
							                    // $value_model->is_deleted = ereg_replace("\n","\n",$value_model->is_deleted);
							                        
									                if (isset($value_model->is_deleted))
								                  	{
								                    	$html.='"'.$value_model->is_deleted.'"' ; 
								                    }
								                    else 
								                    {
								                       $html.='""'; 
									                }

						               		    $html.=");\n"; 
						                }
				                }

			                	if($value_table['Tables_in_customer_ledger_db'] == 'cp_cash_logs')
			            		{
					                    $tableName  = 'cp_cash_logs';
					                    $mode_log  = Cashlogs::model()->findAll();

					                    	foreach ($mode_log as $key => $value_data)
							            	{     
							            		// pr($value_data);          
						              			$html.= 'INSERT INTO '.$tableName.' VALUES(';
						                			
							                    $value_data->id = addslashes($value_data->id);
							                    // $value_data->id = ereg_replace("\n","\n",$value_data->id);

								                  	if (isset($value_data->id))
								                  	{
								                    	$html.='"'.$value_data->id.'",'; 
								                    }
								                    else 
								                    {
								                       $html.='"",'; 
									                }

									            $value_data->cashevent_id = addslashes($value_data->cashevent_id);
							                    // $value_data->cashevent_id = ereg_replace("\n","\n",$value_data->cashevent_id);
								                        
									                if (isset($value_data->cashevent_id))
								                  	{
								                    	$html.='"'.$value_data->cashevent_id.'",'; 
								                    }
								                    else 
								                    {
								                       $html.='"",'; 
									                }

									            $value_data->customer_id = addslashes($value_data->customer_id);
							                    // $value_data->customer_id = ereg_replace("\n","\n",$value_data->customer_id);

									                if (isset($value_data->customer_id))
								                  	{
								                    	$html.='"'.$value_data->customer_id.'",'; 
								                    }
								                    else 
								                    {
								                       $html.='"",'; 
									                }

									            $value_data->item_id = addslashes($value_data->item_id);
							                    // $value_data->item_id = ereg_replace("\n","\n",$value_data->item_id);

									                if (isset($value_data->item_id))
								                  	{
								                    	$html.='"'.$value_data->item_id.'",'; 
								                    }
								                    else 
								                    {
								                       $html.='"",'; 
									                }    


									            $value_data->note = addslashes($value_data->note);
							                    // $value_data->note = ereg_replace("\n","\n",$value_data->note);
								                        
									                if (isset($value_data->note))
								                  	{
								                    	$html.='"'.$value_data->note.'",'; 
								                    }
								                    else 
								                    {
								                       $html.='"",'; 
									                }

									            $value_data->type = addslashes($value_data->type);
								                // $value_data->type = ereg_replace("\n","\n",$value_data->type);
			    
									                if (isset($value_data->type))
								                  	{
								                    	$html.='"'.$value_data->type.'",'; 
								                    }
								                    else 
								                    {
								                       $html.='"",'; 
									                }
									            
									            $value_data->amount = addslashes($value_data->amount);
								                // $value_data->amount = ereg_replace("\n","\n",$value_data->amount);
									            
									                if (isset($value_data->amount))
								                  	{
								                    	$html.='"'.$value_data->amount.'",'; 
								                    }
								                    else 
								                    {
								                       $html.='"",'; 
									                }

									            $value_data->weight = addslashes($value_data->weight);
							                    // $value_data->weight = ereg_replace("\n","\n",$value_data->weight);
								                        
									                if (isset($value_data->weight))
								                  	{
								                    	$html.='"'.$value_data->weight.'",'; 
								                    }
								                    else 
								                    {
								                       $html.='"",'; 
									                }
									            
									            $value_data->gross_weight = addslashes($value_data->gross_weight);
							                    // $value_data->gross_weight = ereg_replace("\n","\n",$value_data->gross_weight);
								                        
									                if (isset($value_data->gross_weight))
								                  	{
								                    	$html.='"'.$value_data->gross_weight.'",'; 
								                    }
								                    else 
								                    {
								                       $html.='"",'; 
									                }	

									            $value_data->description = addslashes($value_data->description);
								                // $value_data->description = ereg_replace("\n","\n",$value_data->description);
								                       
									                if (isset($value_data->description))
								                  	{
								                    	$html.='"'.$value_data->description.'",'; 
								                    }
								                    else 
								                    {
								                       $html.='"",'; 
									                }

									            $value_data->date = addslashes($value_data->date);
								                // $value_data->date = ereg_replace("\n","\n",$value_data->date);
								                        
									                if (isset($value_data->date))
								                  	{
								                    	$html.='"'.$value_data->date.'",'; 
								                    }
								                    else 
								                    {
								                       $html.='"",'; 
									                }

									            $value_data->check_date = addslashes($value_data->check_date);
								                // $value_data->check_date = ereg_replace("\n","\n",$value_data->check_date);    
									            
									                if (isset($value_data->check_date))
								                  	{
								                    	$html.='"'.$value_data->check_date.'",'; 
								                    }
								                    else 
								                    {
								                       $html.='"",'; 
									                }

									            $value_data->status = addslashes($value_data->status);
							                    // $value_data->status = ereg_replace("\n","\n",$value_data->status);
								                        
									                if (isset($value_data->status))
								                  	{
								                    	$html.='"'.$value_data->status.'"'; 
								                    }
								                    else 
								                    {
								                       $html.='""'; 
									                }

						               		    $html.=");\n"; 
					                       }
			                	}
				                
				            $html .= "\n\n\n";
				        }
			        

			        $date_today = date('d-m-Y_H_i_s');
			        $backup_name = 'db-backup'.'-'.$date_today.'.sql';
			    	$file_path = Yii::app()->basePath .'/../database_backup/'.$backup_name;
			        $handle = fopen($file_path,'w+');
					fwrite($handle,$html);
					fclose($handle);


					$file = $file_path;

			       $filetype=filetype($file);

			       $filename=basename($file);

			       header ("Content-Type: ".$filetype);

			       header ("Content-Length: ".filesize($file));

			       header ("Content-Disposition: attachment; filename=".$filename);

			       readfile($file);
			       die;

			        
			        
			        /*Customer::model()->deleteAll();
			        Cashevent::model()->deleteAll();
			        Cashlogs::model()->deleteAll();*/
			        	
			        	Yii::app()->user->setFlash('success', 'Database backup created successfully');
			        	$this->redirect(array('site/index'));
			        	exit;

			    	}
			    	else
			    	{
			    		Yii::app()->user->setFlash('danger', 'Invalid Password');
			       		$this->redirect(array('site/index'));			
			    	}

			    }
			    else
			    {
			    	Yii::app()->user->setFlash('danger', 'Invalid User');
			        $this->redirect(array('site/index'));
			    }

			   }
			   else
			   {
			   		Yii::app()->user->setFlash('danger', 'You did something wrong');
			        $this->redirect(array('site/index'));
			   } 

    	}
    	else
    	{
    		Yii::app()->user->setFlash('danger', 'wrong Password');
       		$this->redirect(array('site/index'));	
    	}
	}

	public function actionCustomer_popup()
	{
		//print_r($_POST);
		// $cust_id = $_POST['cust_id'];
		$model = new Customer;
		// Uncomment the following line if AJAX validation is needed
		if(isset($_POST['ajax']) && $_POST['ajax']==='customer-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
		$this->renderPartial('addcustomer', array('model'=>$model), false,true);
	}

	public function actionGet_customer()
	{
		$customer = Customer::model()->findAll(array('condition'=>'is_deleted=0','order'=>'name asc'));
		$html="<option value=''>----Select Customer----</option>";
		foreach ($customer as $key => $value) 
		{ 
			$html.="<option value='".$value->id."'>".$value->name."</option>";
		}
		echo $html;
		exit();

	}

	public function actionGet_type_customer()
	{
		$customer_type = $_POST['customer_type'];
		$label = "";
		if($customer_type==2)
		$label = "Customer";
		else if($customer_type==3)
		$label = "Karigar";
		else if($customer_type==1)
		$label = "Supplier";
		 
		if($customer_type != "")
		{
			$customer = Customer::model()->findAll(array('condition'=>'type='.$customer_type.' and is_deleted=0','order'=>'name asc'));
		}
		else
		{
			$customer = Customer::model()->findAll(array('condition'=>'is_deleted=0','order'=>'name asc'));
		}
		$html="<option value=''>----Select ".$label."----</option>";
		foreach ($customer as $key => $value) 
		{ 
			$html.="<option value='".$value->id."'>".$value->name."</option>";
		}
		echo $html;
		exit();

	}


	public function actionSave_cash_event()
	{
		/* echo "<pre>";
		 print_r($_POST);
		die(); */
		$model = new Cashevent;
		if(isset($_POST['cust_id']))
		{
			$model->customer_id = $_POST['cust_id'];
		}
		
		if(isset($_POST['cash_type']))
		{
			$model->cash_type =  $_POST['cash_type'];
		}
		if(isset($_POST['gold_type']))
		{
			$model->gold_type =  $_POST['gold_type'];
		}


		if(isset($_POST['cash_type']) && $_POST['cash_type'] == 1)
		{
			$model->amount = $_POST['amount'];	
		}
		if(isset($_POST['gold_type']) && $_POST['gold_type'] == 1)
		{
			$model->gold_amount = $_POST['gold_amount'];	
		}	
		if(isset($_POST['cash_type']) && $_POST['cash_type'] == 2)
		{
			$model->amount = "-".$_POST['amount'];	
		}
		if(isset($_POST['gold_type']) && $_POST['gold_type'] == 2)
		{
			$model->gold_amount = "-".$_POST['gold_amount'];	
		}
		/* $transaction_id_random=$this->referral_code();
		$model->referral_code=$transaction_id_random; */
		$check = Cashevent::model()->find(array('order'=>'id DESC'));				
			$referral_code = $check->referral_code;
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
			$model->referral_code = 'INV'.str_pad( $num, 4, "0", STR_PAD_LEFT );

		if(isset($_POST['create_date']))
		{
			$model->created_date = date('Y-m-d',strtotime($_POST['create_date']));
		}
		if(isset($_POST['note']))
		{
			$model->narration = $_POST['note'];
		}
		$model->user_id = Yii::app()->user->getId();
		// $model->created_date = date('Y-m-d H:i:s');
		/*print_r($model);
		die();*/ 
		if($model->save(false))
		{
			$msg['msg'] = "Cash Add Successfully......";
			echo json_encode($msg);
		}

	}


	public function actionOpenpopup()
	{
		//print_r($_POST);
		// $cust_id = $_POST['cust_id'];
			$model = new Cashevent;
			// if(isset($_POST['cust_id']) && $_POST['cust_id']!='')
			// {
			// 	$model=$this->loadModel($_POST['cust_id']);								
			// }	
		// Uncomment the following line if AJAX validation is needed
		if(isset($_POST['ajax']) && $_POST['ajax']==='cashevent-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
		
		$this->renderPartial('addcash', array('model'=>$model), false,true);


		?>

	<?php
	}

	/**
	 * Displays a particular model.
	 * @param integer $id the ID of the model to be displayed
	 */
	public function actionView_supllier($id)
	{
		$this->render('view',array(
			'model'=>$this->loadModel($id),
		));
	}
	public function actionView_customer($id)
	{
		$this->render('view',array(
			'model'=>$this->loadModel($id),
		));
	}
	public function actionView_karigar($id)
	{
		$this->render('view',array(
			'model'=>$this->loadModel($id),
		));
	}

	public function actionCreate()
	{
		$model=new Customer;

		// Uncomment the following line if AJAX validation is needed
		 $this->performAjaxValidation($model);

		if(isset($_POST['Customer']))
		{
			$model->attributes=$_POST['Customer'];
			if($model->save())
			{

				$msg['msg'] = "Customer Add Successfully......";
					echo json_encode($msg);
					die;
				// Yii::app()->user->setFlash('success', 'Insert successfully');
				// $this->redirect(array('list_supplier'));
				// $this->redirect(array('view','id'=>$model->id));
			}
		}

		$this->render('create',array(
			'model'=>$model,
		));
	}

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate_supplier()
	{
		$model=new Customer;

		// Uncomment the following line if AJAX validation is needed
		 $this->performAjaxValidation($model);

		if(isset($_POST['Customer']))
		{
			$model->attributes=$_POST['Customer'];
			if($model->save())
			{
				Yii::app()->user->setFlash('success', 'Insert successfully');
				// $this->redirect(array('view','id'=>$model->id));
				$this->redirect(array('list_supplier'));
			}
		}

		$this->render('create',array(
			'model'=>$model,
		));
	}

	public function actionCreate_customer()
	{
		$model=new Customer;

		// Uncomment the following line if AJAX validation is needed
		 $this->performAjaxValidation($model);

		if(isset($_POST['Customer']))
		{
			$model->attributes=$_POST['Customer'];
			if($model->save())
			{
				Yii::app()->user->setFlash('success', 'Insert successfully');
				// $this->redirect(array('view','id'=>$model->id));
				$this->redirect(array('list_customer'));
			}
		}

		$this->render('create',array(
			'model'=>$model,
		));
	}


	public function actionCreate_karigar()
	{
		$model=new Customer;

		// Uncomment the following line if AJAX validation is needed
		 $this->performAjaxValidation($model);

		if(isset($_POST['Customer']))
		{
			$model->attributes=$_POST['Customer'];
			if($model->save())
			{
				Yii::app()->user->setFlash('success', 'Insert successfully');
				// $this->redirect(array('view','id'=>$model->id));
				$this->redirect(array('list_karigar'));
			}
		}

		$this->render('create',array(
			'model'=>$model,
		));
	}

	/**
	 * Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id the ID of the model to be updated
	 */

	public function actionUpdate_supplier($id)
	{
		$model=$this->loadModel($id);

		// Uncomment the following line if AJAX validation is needed
		 $this->performAjaxValidation($model);

		if(isset($_POST['Customer']))
		{
			$model->attributes=$_POST['Customer'];
			if($model->save(false))
			{
				Yii::app()->user->setFlash('success', 'Updated successfully');
				// $this->redirect(array('view','id'=>$model->id));
				$this->redirect(array('list_supplier'));
			}
		}
		$this->render('update',array(
			'model'=>$model,
		));
	}


	public function actionUpdate_customer($id)
	{
		$model=$this->loadModel($id);

		// Uncomment the following line if AJAX validation is needed
		 $this->performAjaxValidation($model);

		if(isset($_POST['Customer']))
		{
			$model->attributes=$_POST['Customer'];
			if($model->save(false))
			{
				Yii::app()->user->setFlash('success', 'Updated successfully');
				// $this->redirect(array('view','id'=>$model->id));
				$this->redirect(array('list_customer'));
			}
		}
		$this->render('update',array(
			'model'=>$model,
		));
	}

	public function actionUpdate_karigar($id)
	{
		$model=$this->loadModel($id);

		// Uncomment the following line if AJAX validation is needed
		 $this->performAjaxValidation($model);

		if(isset($_POST['Customer']))
		{
			$model->attributes=$_POST['Customer'];
			if($model->save(false))
			{
				Yii::app()->user->setFlash('success', 'Updated successfully');
				// $this->redirect(array('view','id'=>$model->id));
				$this->redirect(array('list_karigar'));
			}
		}
		$this->render('update',array(
			'model'=>$model,
		));
	}

	/**
	 * Deletes a particular model.
	 * If deletion is successful, the browser will be redirected to the 'admin' page.
	 * @param integer $id the ID of the model to be deleted
	 */

	public function actionDelete($id)
	{
		$model = Customer::model()->findByPk($id);
			if($model)
			{
				$cash_model = Cashevent::model()->findAllByAttributes(array('customer_id'=>$id,'is_deleted'=>0));
			/*	echo "<pre>";
				print_r($cash_model);*/
				foreach ($cash_model as $key => $value) 
				{
					Cashlogs::model()->deleteAll('cashevent_id = :cashevent_id',array(':cashevent_id'=>$value->id));
					/* $log_model = Cashlogs::model()->findAllByAttributes(array('cashevent_id'=>$value->id));
					foreach ($log_model as $key => $value_log)
					{
						$value_log->delete();
					} */
					$value->is_deleted = 1;
					$value->save(false);
				}
				$model->is_deleted = 1;
				$model->save(false);

			}

		/*$this->loadModel($id)->delete();
		if(!isset($_GET['ajax']))
			$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));*/
	}

	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{

		$model=new Customer('search_customer');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Customer']))
			$model->attributes=$_GET['Customer'];

		$this->render('customer_grid',array(
			'model'=>$model,
		));
		/* $dataProvider=new CActiveDataProvider('Customer');
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		)); */
	}

	/**
	 * Manages all models.
	 */
	public function actionList_supplier()
	{
		$model=new Customer('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Customer']))
			$model->attributes=$_GET['Customer'];

		$this->render('admin',array(
			'model'=>$model,
		));
	}

	public function actionList_customer()
	{
		$model=new Customer('search_customer');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Customer']))
			$model->attributes=$_GET['Customer'];

		$this->render('customer_grid',array(
			'model'=>$model,
		));
	}

	public function actionList_karigar()
	{
		$model=new Customer('search_karigar');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Customer']))
			$model->attributes=$_GET['Customer'];

		$this->render('karigar_grid',array(
			'model'=>$model,
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return Customer the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=Customer::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param Customer $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='customer-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
