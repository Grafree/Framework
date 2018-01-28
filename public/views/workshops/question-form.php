<?php self::_render( 'components/page-header', [ 
                            'title'             =>'Question', 
                            'backbtn-display'   =>true, 
                            'backbtn-url'       =>'/workshops/questions', 
                            'backbtn-label'     =>'Retour aux questions'
                        ] ); ?>

<div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">

    <?php self::_render( 'components/tabs-toolsheader', [ 
                            'tabs'=>$datas->tabs
                        ] ); ?>
                                
     <section>
                  
    <?php self::_render( 'components/section-toolsheader', [ 
                                        'title'           =>'Question',
                                        'subtitle'        =>' - Modifier', 
                                        'response'        =>$datas->response
                                    ] ); ?>

        <div class="x_content">
            <br />

            <form action="<?php echo SITE_URL; ?>/workshops/questionupdate/<?php echo $datas->form->IDQuestion; ?>" method="post" class="form-horizontal form-label-left" enctype="multipart/form-data" >

            <?php self::_render( 'components/form-field', [
                        'title'=>'Question', 
                        'name'=>'Question', 
                        'values'=>$datas->form, 
                        'type'=>'input-text', 
                        'required'=>true
                ] ); ?>
                
            <?php self::_render( 'components/form-field', [
                        'title'=>'Formation', 
                        'name'=>'IdWorkshop', 
                        'values'=>$datas->form, 
                        'type'=>'select',
                        'options'=>$datas->workshops,
                        'option-value'=>'value', 
                        'option-label'=>'label',
                        'first-option'=>'Toutes les formations',
                        'first-value'=>0
                ] ); ?>
            
            <?php self::_render( 'components/form-field', [
                        'title'=>'Type de question', 
                        'name'=>'TypeQuestion', 
                        'values'=>$datas->form, 
                        'type'=>'select',
                        'options'=>$datas->typeQuestions,
                        'option-value'=>'value', 
                        'option-label'=>'label',
                        'first-option'=>'',
                        'first-label'=>'Textes (instructions)'
                ] ); ?>
            
                <div class="form-group">
                    <div class="col-md-9 col-sm-9 col-xs-12 col-md-offset-3">
                        <button type="submit" class="btn btn-success">Envoyer</button>
                    </div>
                </div>

            </form>


         </section>
    </div>
</div>