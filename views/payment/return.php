<?php

use yii\helpers\Html;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $model queue\models\QmQueues */

$this->title = Yii::t('paymentgate_alphabank','Payment processing');

$this->params['breadcrumbs'][] = $this->title;
?>
<div class="paymentgate-return">

    <h1><?= Html::encode($this->title) ?></h1>
    
    <?php
        if( isset($orderStatusDescription) && !empty( $orderStatusDescription ) ) {
            echo Html::tag( 'p', $orderStatusDescription );
        }
    ?>
    
    <?php if( $payment->isProcess ): ?>
    
        <p><?php echo Yii::t('paymentgate_alphabank','Please, wait. Your payment is processing.'); ?></p>
    
    <?php elseif( $payment->isAccept ): ?>
        
        <p><?php echo Yii::t('paymentgate_alphabank','Your payment is accepted.'); ?></p>
        
    <?php elseif( $payment->isAbort ): ?>
    
        <p><?php echo Yii::t('paymentgate_alphabank','Sorry, your payment has been aborted.'); ?></p>
    
    <?php else: ?>
    
        <p><?php echo Yii::t('paymentgate_alphabank','Your payment not processed. Try to re-enter your payment details.'); ?></p>
    
    <?php endif; ?>
    
    <?php
        if( !empty($paymentGate->errors) ) {
            echo Html::tag('p', implode(' ', $paymentGate->errors) );
        }
    ?>
    
    <div>
        
        <?php
            if( !empty($paymentGate->returnUrl) ) echo Html::a(Yii::t('paymentgate_alphabank', 'Return'), [ $paymentGate->returnUrl ], ['class' => 'btn btn-primary paymentgate-btn']);

            $paymentIdField = $paymentGate->paymentIdField;
            if( !empty($paymentGate->viewUrl) ) echo Html::a(Yii::t('paymentgate_alphabank', 'Payment details'), [ $paymentGate->viewUrl, $paymentIdField => $payment->$paymentIdField ], ['class' => 'btn btn-warning paymentgate-btn']);
            
            $restartButtonConfig = ['class' => 'btn btn-warning paymentgate-btn restart'];
            if( $payment->isAbort ) {
        
                if( !empty($paymentGate->restartUrl) ) echo Html::a(Yii::t('paymentgate_alphabank', 'Restart payment'), [ $paymentGate->restartUrl ], $restartButtonConfig);
        
            } elseif( $payment->isProcess ) {
        
                if( !empty($paymentGate->restartUrl) ) echo Html::a(Yii::t('paymentgate_alphabank', 'Refresh payment'), Url::current(), $restartButtonConfig);
        
            } elseif( $payment->isAccept ) {
        
                if( !empty($paymentGate->restartUrl) ) echo Html::a(Yii::t('paymentgate_alphabank', 'Restart payment'), $paymentGate->restartUrl, $restartButtonConfig);
        
            }
        ?>
    
    </div>

</div>
