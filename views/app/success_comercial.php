<?php

use yii\helpers\ArrayHelper;

$this->title = $model->name;
$this->params['breadcrumbs'][] = $this->title;

//$porc = Yii::$app->params['porcentagemComercial'];
$tot_h = 0;
$tot_i = 0;

?>

<style>
    .table.table-result {
        border-collapse: collapse;
    }
    .table th, .table td {
        padding: 2px;
    }
    b {
        font-weight: 700;
    }
</style>

<div class="area">

    <div class="row">

        <div class="col s12 m6 card pl-0 pr-0">

            <div class="card-header" style="background: #1761a0">

                <h3 class="text-white m-b-0 m-t-0"><img style="width: 50px;"
                                                        src="/img/logo-white-mini.png"> <?= $this->title ?></h3>

            </div>

            <div class="p-4" id="render-dynamic-form">

                <table class="table table-result table-bordered table-striped table-bordered">
                    <thead>
                    <tr style="background: #1761a0; color: #FFF;">
                        <th><b><?= ArrayHelper::getValue($data[1], 1, 0); ?></b></th>
                        <th class="text-center"><b>CUSTO SubPP</b></th>
                        <th class="text-center"><b>CUSTO ATUAL</b></th>
                        <th class="text-center" style="background-color: green;"><b>NET</b></th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php $count = count($data[2]); ?>
                    <?php for ($x = 1; $x <= $count; $x++): ?>
                    <?php
                    $e = ArrayHelper::getValue($data[2], $x, 0) / 100;
                    $f = ArrayHelper::getValue($data[3], $x, 0);
                    $porc = ArrayHelper::getValue($data[4], 11, 0);
                        if($f > 0 && $e > 0) :
                            $d = ($e + 0.02);
                            $f = ArrayHelper::getValue($data[3], $x, 0);
                            $h = ($f * $d);
                            $i = (($e + $porc) * $f);
                            $j = ($i - $h);
                            $tot_h += $h;
                            $tot_i += $i;
                        ?>
                            <tr>
                                <td>
                                    <b>
                                        <?php

                                        if ($x == 1) {
                                            echo 'Débito';
                                        } elseif ($x == 2) {
                                            echo 'Crédito à Vista';
                                        } else {
                                            echo 'Parcelamento sem juros (' . ($x - 1) . 'x)';
                                        }
                                        ?>
                                    </b>
                                </td>
                                <td class="text-center">R$ <?= number_format($h, 2, ',', '.') ?></td>
                                <td class="text-center">R$ <?= number_format($i, 2, ',', '.') ?></td>
                                <td class="text-center">R$ <?= number_format($j, 2, ',', '.') ?></td>
                            </tr>

                        <?php endif; ?>

                    <?php endfor; ?>

                    <?php if(isset($data[4])): ?>

                        <?php $hm =  ArrayHelper::getValue($data[4], 2, 0) * 69; ?>
                        <?php $hp =  ArrayHelper::getValue($data[4], 4, 0) * 2.99; ?>
                        <?php $ht =  ArrayHelper::getValue($data[4], 6, 0) * 2.99; ?>
                        <?php $hb =  ArrayHelper::getValue($data[4], 8, 0) * 3.99; ?>
                        <?php $hc =  ArrayHelper::getValue($data[4], 10, 0) * 79.9; ?>

                        <?php $im =  ArrayHelper::getValue($data[4], 1, 0); ?>
                        <?php $ip =  ArrayHelper::getValue($data[4], 3, 0); ?>
                        <?php $it =  ArrayHelper::getValue($data[4], 5, 0); ?>
                        <?php $ib =  ArrayHelper::getValue($data[4], 7, 0); ?>
                        <?php $ic =  ArrayHelper::getValue($data[4], 9, 0); ?>

                        <?php $tot_h +=  $hm + $hp + $ht + $hb + $hc; ?>
                        <?php $tot_i +=  $im + $ip + $it + $ib + $ic; ?>

                        <?php if($hm > 0 && $im > 0) : ?>

                            <tr>
                                <td colspan="4"></td>
                            </tr>
                            <tr>
                                <td>
                                    <b>Mensalidade POS</b>
                                </td>
                                <td class="text-center">R$ <?= number_format($hm, 2, ',', '.') ?></td>
                                <td class="text-center">R$ <?= number_format($im, 2, ',', '.') ?></td>
                                <td class="text-center">R$ <?= number_format($im - $hm, 2, ',', '.') ?></td>
                            </tr>

                        <?php endif; ?>

                        <?php if($hp > 0 && $ip > 0) : ?>

                            <tr>
                                <td colspan="4"></td>
                            </tr>
                            <tr>
                                <td>
                                    <b>Tarifa PIX</b>
                                </td>
                                <td class="text-center">R$ <?= number_format($hp, 2, ',', '.') ?></td>
                                <td class="text-center">R$ <?= number_format($ip, 2, ',', '.') ?></td>
                                <td class="text-center">R$ <?= number_format($ip - $hp, 2, ',', '.') ?></td>
                            </tr>

                        <?php endif; ?>

                        <?php if($ht > 0 && $it > 0) : ?>

                            <tr>
                                <td colspan="4"></td>
                            </tr>
                            <tr>
                                <td>
                                    <b>Tarifa TED</b>
                                </td>
                                <td class="text-center">R$ <?= number_format($ht, 2, ',', '.') ?></td>
                                <td class="text-center">R$ <?= number_format($it, 2, ',', '.') ?></td>
                                <td class="text-center">R$ <?= number_format($it - $ht, 2, ',', '.') ?></td>
                            </tr>

                        <?php endif; ?>

                        <?php if($hb > 0 && $ib > 0) : ?>

                            <tr>
                                <td colspan="4"></td>
                            </tr>
                            <tr>
                                <td>
                                    <b>Tarifa de Boleto</b>
                                </td>
                                <td class="text-center">R$ <?= number_format($hb, 2, ',', '.') ?></td>
                                <td class="text-center">R$ <?= number_format($ib, 2, ',', '.') ?></td>
                                <td class="text-center">R$ <?= number_format($ib - $hb, 2, ',', '.') ?></td>
                            </tr>

                        <?php endif; ?>

                        <?php if($hc > 0 && $ic > 0) : ?>

                            <tr>
                                <td colspan="4"></td>
                            </tr>
                            <tr>
                                <td>
                                    <b>Manutenção da Conta</b>
                                </td>
                                <td class="text-center">R$ <?= number_format($hc, 2, ',', '.') ?></td>
                                <td class="text-center">R$ <?= number_format($ic, 2, ',', '.') ?></td>
                                <td class="text-center">R$ <?= number_format($ic - $hc, 2, ',', '.') ?></td>
                            </tr>

                        <?php endif; ?>

                    <?php endif; ?>

                    <tr>
                        <td colspan="4"></td>
                    </tr>

                    <tr>
                        <td>
                            <b>TOTAL</b>
                        </td>
                        <td class="text-center">R$ <?= number_format($tot_h, 2, ',', '.') ?></td>
                        <td class="text-center">R$ <?= number_format($tot_i, 2, ',', '.') ?></td>
                        <td class="text-center" style="background-color: green; color: #FFF">
                            <b>R$ <?= number_format($tot_i - $tot_h, 2, ',', '.') ?></b>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="4"></td>
                    </tr>
                    <tr>
                        <td colspan="3"></td>
                        <td class="text-center" style="background-color: green; color: #FFF">
                            <b>R$ <?= number_format(($tot_i - $tot_h) * 12, 2, ',', '.') ?></b>
                        </td>
                    </tr>
                    </tbody>
                </table>

            </div>

        </div>

    </div>

</div>
