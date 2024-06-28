<?php

namespace app\commands;

use app\helpers\FormHelper;
use app\models\Form;
use app\models\FormQuestion;
use yii\console\Controller;
use yii\helpers\ArrayHelper;

class ComercialController extends Controller
{
    public function actionCreate($area_id, $user_id)
    {
        $dform1 = [
            'name' => 'Dados da Empresa',
            'items' => [
                ['Nome da empresa', true],
                ['Quem faz a sua movimentação financeira?'],
                ['Como está e com quem está o seu recebimento com as maquininhas?'],
                ['Você tem mais de uma empresa/CNPJ atualmente?'],
            ]
        ];

        $form = new Form();
        $form->id_user = $user_id;
        $form->name = $dform1['name'];
        if(!$form->save()) {
            var_dump($form->errors);die;
        }

        foreach($dform1['items'] as $order => $item){
            $ques = new FormQuestion();
            $ques->id_form = $form->id;
            $ques->name = $item[0];
            $ques->order = $order + 1;
            $ques->type = ArrayHelper::getValue($item, 2, FormHelper::CAMPO_TEXTFIELD);
            $ques->size = 12;
            $ques->is_mandatory = ArrayHelper::getValue($item, 1, false);
            $ques->save();
        }

        $dform2 = [
            'name' => 'Eu preciso saber quais são as suas taxas atuais',
            'items' => [
                ['Qual taxa você paga para as vendas no Débito?', true, FormHelper::CAMPO_PERCENT],
                ['Qual taxa você paga para as vendas no Crédito à Vista?', true, FormHelper::CAMPO_PERCENT],
                ['Qual taxa você paga para os parcelamentos sem juros, em 2 vezes?', true, FormHelper::CAMPO_PERCENT],
                ['Qual taxa você paga para os parcelamentos sem juros, em 3 vezes?', false, FormHelper::CAMPO_PERCENT],
                ['Qual taxa você paga para os parcelamentos sem juros, em 4 vezes?', false, FormHelper::CAMPO_PERCENT],
                ['Qual taxa você paga para os parcelamentos sem juros, em 5 vezes?', false, FormHelper::CAMPO_PERCENT],
                ['Qual taxa você paga para os parcelamentos sem juros, em 6 vezes?', false, FormHelper::CAMPO_PERCENT],
                ['Qual taxa você paga para os parcelamentos sem juros, em 7 vezes?', false, FormHelper::CAMPO_PERCENT],
                ['Qual taxa você paga para os parcelamentos sem juros, em 8 vezes?', false, FormHelper::CAMPO_PERCENT],
                ['Qual taxa você paga para os parcelamentos sem juros, em 9 vezes?', false, FormHelper::CAMPO_PERCENT],
                ['Qual taxa você paga para os parcelamentos sem juros, em 10 vezes?', false, FormHelper::CAMPO_PERCENT],
                ['Qual taxa você paga para os parcelamentos sem juros, em 11 vezes?', false, FormHelper::CAMPO_PERCENT],
                ['Qual taxa você paga para os parcelamentos sem juros, em 12 vezes?', false, FormHelper::CAMPO_PERCENT],
            ]
        ];

        $form = new Form();
        $form->id_user = $user_id;
        $form->name = $dform2['name'];
        if(!$form->save()) {
            var_dump($form->errors);die;
        }

        foreach($dform2['items'] as $order => $item){
            $ques = new FormQuestion();
            $ques->id_form = $form->id;
            $ques->name = $item[0];
            $ques->order = $order + 1;
            $ques->type = ArrayHelper::getValue($item, 2, FormHelper::CAMPO_TEXTFIELD);
            $ques->size = 12;
            $ques->is_mandatory = ArrayHelper::getValue($item, 1, false);
            $ques->save();
        }

        $dform3 = [
            'name' => 'Eu preciso saber quais são as suas médias de faturamento',
            'items' => [
                ['Qual é o seu faturamento médio no Débito?', true, FormHelper::CAMPO_MONEY],
                ['Qual é o seu faturamento médio no Crédito à Vista?', true, FormHelper::CAMPO_MONEY],
                ['Qual é o seu faturamento médio nos parcelamentos sem juros, em 2 vezes?', true, FormHelper::CAMPO_MONEY],
                ['Qual é o seu faturamento médio nos parcelamentos sem juros, em 3 vezes?', false, FormHelper::CAMPO_MONEY],
                ['Qual é o seu faturamento médio nos parcelamentos sem juros, em 4 vezes?', false, FormHelper::CAMPO_MONEY],
                ['Qual é o seu faturamento médio nos parcelamentos sem juros, em 5 vezes?', false, FormHelper::CAMPO_MONEY],
                ['Qual é o seu faturamento médio nos parcelamentos sem juros, em 6 vezes?', false, FormHelper::CAMPO_MONEY],
                ['Qual é o seu faturamento médio nos parcelamentos sem juros, em 7 vezes?', false, FormHelper::CAMPO_MONEY],
                ['Qual é o seu faturamento médio nos parcelamentos sem juros, em 8 vezes?', false, FormHelper::CAMPO_MONEY],
                ['Qual é o seu faturamento médio nos parcelamentos sem juros, em 9 vezes?', false, FormHelper::CAMPO_MONEY],
                ['Qual é o seu faturamento médio nos parcelamentos sem juros, em 10 vezes?', false, FormHelper::CAMPO_MONEY],
                ['Qual é o seu faturamento médio nos parcelamentos sem juros, em 11 vezes?', false, FormHelper::CAMPO_MONEY],
                ['Qual é o seu faturamento médio nos parcelamentos sem juros, em 12 vezes?', false, FormHelper::CAMPO_MONEY],
            ]
        ];

        $form = new Form();
        $form->id_user = $user_id;
        $form->name = $dform3['name'];
        if(!$form->save()) {
            var_dump($form->errors);die;
        }

        foreach($dform3['items'] as $order => $item){
            $ques = new FormQuestion();
            $ques->id_form = $form->id;
            $ques->name = $item[0];
            $ques->order = $order + 1;
            $ques->type = ArrayHelper::getValue($item, 2, FormHelper::CAMPO_TEXTFIELD);
            $ques->size = 12;
            $ques->is_mandatory = ArrayHelper::getValue($item, 1, false);
            $ques->save();
        }

        $dform4 = [
            'name' => 'Outras informações importantes',
            'items' => [
                ['Quanto custa por mês cada maquininha - POS?', true, FormHelper::CAMPO_MONEY],
                ['Quantas maquininhas (POS) você tem na sua operação?', true, FormHelper::CAMPO_NUMBER],
                ['Quanto custa cada operação de Pix (cash in/out)?', true, FormHelper::CAMPO_MONEY],
                ['Quantos Pix você faz em média por mês?', true, FormHelper::CAMPO_NUMBER],
                ['Quanto custa cada operação de TED?', true, FormHelper::CAMPO_MONEY],
                ['Quantos TEDs você faz em média por mês?', true, FormHelper::CAMPO_NUMBER],
                ['Quanto você paga por cada Boleto?', true, FormHelper::CAMPO_MONEY],
                ['Quantos boletos você emite em média por mês?', true, FormHelper::CAMPO_NUMBER],
                ['Quantos CNPJs você tem ativos nessa operação?', true, FormHelper::CAMPO_NUMBER],
                ['Quantos por cento você paga em média de imposto?', true, FormHelper::CAMPO_PERCENT],
            ]
        ];

        $form = new Form();
        $form->id_user = $user_id;
        $form->name = $dform4['name'];
        if(!$form->save()) {
            var_dump($form->errors);die;
        }

        foreach($dform4['items'] as $order => $item){
            $ques = new FormQuestion();
            $ques->id_form = $form->id;
            $ques->name = $item[0];
            $ques->order = $order + 1;
            $ques->type = ArrayHelper::getValue($item, 2, FormHelper::CAMPO_TEXTFIELD);
            $ques->size = 12;
            $ques->is_mandatory = ArrayHelper::getValue($item, 1, false);
            $ques->save();
        }
    }
}