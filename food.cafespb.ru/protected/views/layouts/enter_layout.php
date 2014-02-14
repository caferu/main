<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
        "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="ru" lang="ru">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=<?= Yii::app()->charset ?>"/>
    <meta name="language" content="ru"/>
    <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/main.css"/>
    <title><?php echo CHtml::encode($this->pageTitle); ?></title>
</head>

<body>

<table style="width:100%">
    <tr>
        <td class="main_empty_field">&nbsp;</td>
        <td id="main_column">
            <table>
                <tr>
                    <td id="ramka_td_left">
                        <div>&nbsp;</div>
                    </td>
                    <td id="ramka_td_bg">
                        <div id="login_place">
                            <table>
                                <tr>
                                    <td id="login_td_left">
                                        <div>&nbsp;</div>
                                    </td>
                                    <td id="login_td_bg">
                                        <div class='content_place'>
                                           <div style="overflow: auto; padding-top: 70px;  padding-bottom: 60px; font-size: 16px">&nbsp;
                                               Cafespb.ru
                                               <div >Доставка еды</div>
                                           </div>
                                            <?php echo $content; ?>
                                            <div class="copy">
                                                &copy; 2009 - <?php echo date('Y'); ?>  ООО "БОРДО".
                                                <img src="/images/decor.gif" alt="" id="decor"/>
                                            </div>
                                        </div>
                                    </td>
                                    <td id="login_td_right">
                                        <div>&nbsp;</div>
                                    </td>
                                </tr>
                            </table>
                        </div>
                    </td>
                    <td id="ramka_td_right">
                        <div>&nbsp;</div>
                    </td>
                </tr>
            </table>
        </td>
        <td class="main_empty_field">&nbsp;</td>
    </tr>
</table>

</body>
</html>