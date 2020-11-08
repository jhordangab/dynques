<?php

namespace app\helpers;

use Yii;

class FormHelper
{
    CONST CAMPO_DATE = 'date';
    CONST CAMPO_CNPJ = 'cnpj';
    CONST CAMPO_CPF = 'cpf';
    CONST CAMPO_PHONE = 'phone';
    CONST CAMPO_CEP = 'cep';
    CONST CAMPO_VIEW = 'view';
    CONST CAMPO_HOUR = 'hour';
    CONST CAMPO_MONEY = 'money';
    CONST CAMPO_RADIOLIST = 'radiolist';
    CONST CAMPO_SELECT = 'select';
    CONST CAMPO_SELECT_MULTIPLE = 'selectmultiple';
    CONST CAMPO_CHECKBOX = 'checkbox';
    CONST CAMPO_CHECKBOX_MULTIPLE = 'checkboxmultiple';
    CONST CAMPO_NUMBER = 'number';
    CONST CAMPO_TEXTFIELD = 'textfield';
    CONST CAMPO_TEXTAREA = 'textarea';
    CONST CAMPO_PASSWORD = 'password';
    CONST CAMPO_IMAGE = 'image';
    CONST CAMPO_IMAGE_MULTIPLE = 'imagemultiple';
    CONST CAMPO_SIGN = 'sign';

    public static function getCampos()
    {
        return [
            self::CAMPO_SIGN => Yii::t('app', 'field.sign'),
            self::CAMPO_CEP => Yii::t('app', 'field.cep'),
            self::CAMPO_CHECKBOX => Yii::t('app', 'field.checkbox'),
            self::CAMPO_CNPJ => Yii::t('app', 'field.cnpj'),
            self::CAMPO_CPF => Yii::t('app', 'field.cpf'),
            self::CAMPO_DATE => Yii::t('app', 'field.date'),
            self::CAMPO_HOUR => Yii::t('app', 'field.hour'),
            self::CAMPO_IMAGE => Yii::t('app', 'field.image'),
            self::CAMPO_RADIOLIST => Yii::t('app', 'field.radiolist'),
            self::CAMPO_SELECT => Yii::t('app', 'field.combobox'),
            self::CAMPO_MONEY => Yii::t('app', 'field.money'),
            self::CAMPO_IMAGE_MULTIPLE => Yii::t('app', 'field.images'),
            self::CAMPO_CHECKBOX_MULTIPLE => Yii::t('app', 'field.checkboxlist'),
            self::CAMPO_SELECT_MULTIPLE => Yii::t('app', 'field.comboboxlist'),
            self::CAMPO_NUMBER => Yii::t('app', 'field.number'),
            self::CAMPO_PASSWORD => Yii::t('app', 'field.password'),
            self::CAMPO_PHONE => Yii::t('app', 'field.phone'),
            self::CAMPO_TEXTAREA => Yii::t('app', 'field.textarea'),
            self::CAMPO_TEXTFIELD => Yii::t('app', 'field.textfield'),
            self::CAMPO_VIEW => Yii::t('app', 'field.view'),
        ];
    }

    public static function getCampo($cdg)
    {
        $campos = self::getCampos();
        return $campos[$cdg];
    }
}