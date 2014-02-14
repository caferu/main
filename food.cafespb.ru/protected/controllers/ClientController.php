<?php

class ClientController extends Controller
{
    public $demand;

    public function init()
    {
        if (!empty($_GET['id'])) {
            $this->demand = Demands::model()->findByAttributes(array('c_metka' => $_GET['id']));
            if (!empty($this->demand)) Yii::app()->user->setState('demand', $this->demand);
            else $this->redirect('site/index');
        }
        if (isset(Yii::app()->user->demand)) {
            $this->demand = Yii::app()->user->demand;
        }
        parent::init();
    }

    public function filters()
    {
        return array(
            'accessControl', // perform access control for CRUD operations
        );
    }

    public function accessRules()
    {
        return array(
            array('allow',
                  'users' => array('*'),
            ),
        );
    }

    public function actionIndex()
    {
        // if (empty($this->demand))
        //    throw new CHttpException(404, Yii::t('ru','The requested page does not exist.'));

        $this->layout = 'client';
        $model = $this->demand;

        if (!empty($_POST['Demands'])) {
            $model->attributes = $_POST['Demands'];
            $model->is_demand_status = 4;
            $model->t_change = date('Y-m-d H:i:s');
            $model->t_confirm = date('Y-m-d H:i:s');
            $model->save();
            $text_sms = 'Получено подтверждение по заказу №' . $model->id;
            $text_sms .= '. Заказчик: ' . $model->c_customer . '. Телефон: ' . $model->c_phone . '.';


            if (!empty($model->Agent->c_phone)) {
                $sms = new MySmsSender();
                $sms->send($model->c_phone, $text_sms, $model->id . '_' . date('is'));
            }
            /*$sql = "SELECT distinct b.c_email FROM cf_users b LEFT JOIN cf_security a ON (a.id_user=b.id_user)
                        WHERE (a.id_security in (10)  or b.id_user=" . $model->id_agent . " ) and b.status=1";
            $command = Yii::app()->db->createCommand($sql);
            $debug_mail = $command->queryColumn();
            $demand_info = '';

            $demand_info .= 'Тип заказчика: ' . $model->CustomerType->c_name . '<br>';
            $demand_info .= 'Дата мероприятия: ' . $model->dateEvent . '<br>';
            $demand_info .= 'Тип банкета: ' . $model->BanketType->c_name . '<br>';
            $demand_info .= 'Количество человек: ' . $model->i_person . '<br>';
            $demand_info .= 'Сумма на человека: ' . $model->i_sum_person . '<br>';
            $demand_info .= 'Тип оплаты: ' . $model->KindPay->c_name . '<br>';
            $demand_info .= 'Свой алкоголь: ' . Yii::app()->format->boolean($model->b_alko) . '<br>';
            $demand_info .= 'Закрытие площадки: ' . Yii::app()->format->boolean($model->b_close) . '<br>';
            $demand_info .= 'Дополнительные условия: ' . $model->t_comment . '<br><br>Контактные данные:<br>';
            $demand_info .= 'Имя заказчика: ' . $model->c_customer . '<br>';
            $demand_info .= 'E-mail: ' . $model->c_mail . '<br>';
            $demand_info .= 'Телефон: ' . $model->c_phone . '<br><br>';
            $demand_info .= 'Ответ закaзчика: ' . $model->t_offer_comment . '<br>';
            $demand_info .= 'Подарок: ' . $model->Gift->c_name . '<br>';

            $debug_subj = 'Получен список заведений от клиента для проведения мероприятия';
            $debug_text = 'Получен список заведений от клиента для проведения мероприятия.<br>Номер заявки: ' . $model->id . '.<br>Менеджер: ' . $model->Agent->c_name . '<br>';
            $debug_text .= '<br><br>' . $demand_info;

            $sql = 'select id_object from cf_demand_object where id_demand=' . $model->id . ' and point>0';
            $command = Yii::app()->db->createCommand($sql);
            $a_goods = $command->queryColumn();
            if (!empty($a_goods)) {
                $sql = "Select * from goods where id in (" . implode(',', $a_goods) . ")";
                $command = Yii::app()->db_old->createCommand($sql);
                $goods = $command->queryAll();
                $n_goods = array();
                foreach ($goods as $k => $v) {
                    $n_goods[] = '(' . $v['id'] . ') ' . $v['c_name'];
                    //$a_owner_mail[] = $v['info_mail'];
                }
                $str_goods = implode(', ', $n_goods);
                $debug_text .= '<br><br>Выбранные заведения: ' . $str_goods;
            }
            $mess = new Messages;
            $mess->attributes = array('id_tape' => 7, 'c_header' => $debug_subj, 't_content' => $debug_text, 'id_user' => -1);
            if ($mess->save()) {
                $rep = new SubsReports;
                $rep->id_message = $mess->id;
                if ($rep->save()) {
                    foreach ($debug_mail as $k => $v) {
                        if (!empty($v)) {
                            $r_mail = new SubsReportMails;
                            $r_mail->attributes = array('id_sub_report' => $rep->id, 'c_mail' => $v);
                            $r_mail->save();
                        }
                    }
                }
            }

*/
        } else {
            if (empty($model->t_view)) $model->t_view = date('Y-m-d H:i:s');
            $model->b_view_offer = 1;
            $model->save();
        }
        // var_dump ($model->attributes);
        $this->render('index');
    }

    public function actionNewOffer()
    {
        $this->layout = 'client';
        $model = $this->demand;
        $model->t_offer_comment = $_GET['t_comment'];
        $model->is_demand_status = 9;
        $model->t_change = date('Y-m-d H:i:s');
        $model->save();
        $sql = "SELECT distinct b.c_email FROM cf_users b LEFT JOIN cf_security a ON (a.id_user=b.id_user)
                        WHERE (a.id_security in (10)  or b.id_user=" . $model->id_agent . " ) and b.status=1";
        $command = Yii::app()->db->createCommand($sql);
        $debug_mail = $command->queryColumn();
        $demand_info = '';

        $demand_info .= 'Тип заказчика: ' . $model->CustomerType->c_name . '<br>';
        $demand_info .= 'Дата мероприятия: ' . $model->dateEvent . '<br>';
        $demand_info .= 'Тип банкета: ' . $model->BanketType->c_name . '<br>';
        $demand_info .= 'Количество человек: ' . $model->i_person . '<br>';
        $demand_info .= 'Сумма на человека: ' . $model->i_sum_person . '<br>';
        $demand_info .= 'Тип оплаты: ' . $model->KindPay->c_name . '<br>';
        $demand_info .= 'Свой алкоголь: ' . Yii::app()->format->boolean($model->b_alko) . '<br>';
        $demand_info .= 'Закрытие площадки: ' . Yii::app()->format->boolean($model->b_close) . '<br>';
        $demand_info .= 'Дополнительные условия: ' . $model->t_comment . '<br><br>Контактные данные:<br>';
        $demand_info .= 'Имя заказчика: ' . $model->c_customer . '<br>';
        $demand_info .= 'E-mail: ' . $model->c_mail . '<br>';
        $demand_info .= 'Телефон: ' . $model->c_phone . '<br><br>';
        $demand_info .= 'Ответ закaзчика: ' . $model->t_offer_comment . '<br>';

        $debug_subj = 'Запрос на новую подборку заведений';
        $debug_text = 'Получен запрос на новую подборку заведений.<br>Номер заявки: ' . $model->id . '.<br>Менеджер: ' . $model->Agent->c_name . '<br>';
        $debug_text .= '<br><br>' . $demand_info;

        $text_sms = 'Запрос на новую подборку заведений. Заказ №' . $model->id;
        $text_sms .= '. Заказчик: ' . $model->c_customer . '. Телефон: ' . $model->c_phone . '.';
        if (!empty($model->t_offer_comment)) {
            $text_sms .= '. Ответ: ' . $model->t_offer_comment;
        }

        if (!empty($model->Agent->c_phone)) {
            $sms = new MySmsSender();
            $sms->send($model->c_phone, $text_sms, $model->id . '_' . date('is'));
        }

        $mess = new Messages;
        $mess->attributes = array('id_tape' => 7, 'c_header' => $debug_subj, 't_content' => $debug_text, 'id_user' => -1);
        if ($mess->save()) {
            $rep = new SubsReports;
            $rep->id_message = $mess->id;
            if ($rep->save()) {
                foreach ($debug_mail as $k => $v) {
                    if (!empty($v)) {
                        $r_mail = new SubsReportMails;
                        $r_mail->attributes = array('id_sub_report' => $rep->id, 'c_mail' => $v);
                        $r_mail->save();
                    }
                }
            }
        }
        // var_dump ($model->attributes);
        $this->render('index');
    }
}