<?php

$this->title = 'Cadastrar Formulário';
$this->params['breadcrumbs'][] = ['label' => 'Formulários', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

?>

<div class="form-create">

    <div class="row">

        <div class="col-lg-12 col-md-12">

            <div class="card card-outline-plan">

                <div class="card-body">

                    <?= $this->render('_form', [
                        'model' => $model,
                    ]) ?>

                </div>

            </div>

        </div>

    </div>

</div>