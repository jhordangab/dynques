<?php

$this->title = 'Cadastrar Quiz';
$this->params['breadcrumbs'][] = ['label' => 'Quiz', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

?>

<div class="quiz-create">

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