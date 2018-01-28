<?php self::_render( 'components/page-header', [ 'title' =>'Enquête de la formation' ] ); ?>

<div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
     <section>
                  
    <?php self::_render( 'components/section-toolsheader', [ 
                                        'title'           =>$datas->datas->TitleWorkshop,
                                        'subtitle'        =>'', 
                                        //'response'        =>$datas->response
                                    ] ); ?>

        <div class="x_content">
            <br />
            <?php if( !empty( $datas->datas->IsEvalUserWorkshop ) ) { ?>
            
                <h2>Merci d'avoir pris le temps de répondre à cette enquête.</h2>
                
                <p><a class="btn btn-info" href="<?php echo SITE_URL; ?>">Quitter l'enquête</a></p>
                
            <?php }else{ ?>
            
                <form action="<?php echo SITE_URL; ?>/workshops/private/sent" method="post" class="form-horizontal form-label-left" enctype="multipart/form-data" >
                    
                    <?php
                        self::_render( 'components/form-field', [
                                'name'=>'IdUserWorkshop', 
                                'values'=>$datas->datas, 
                                'type'=>'input-hidden'
                        ] ); 
                    ?>
                    <?php 
                    foreach( $datas->questionsGen as $question )
                    {
                        self::_render( 'components/form-field', [
                                'title'=>$question->Question, 
                                'name'=>$question->formFields['name'], 
                                'values'=>$question->formFields['values'], 
                                'type'=>$question->formFields['type']
                        ] ); 
                    }
                    ?>
                    <hr>
                    <h3>Plus spécifiquement :</h3>
                    <?php 
                    foreach( $datas->questionsSpec as $question )
                    {
                        self::_render( 'components/form-field', [
                                'title'=>$question->Question, 
                                'name'=>$question->formFields['name'], 
                                'values'=>$question->formFields['values'], 
                                'type'=>$question->formFields['type']
                        ] ); 
                    }
                    ?>

                    <div class="form-group">
                        <div class="col-md-9 col-sm-9 col-xs-12 col-md-offset-3">
                            <button type="submit" class="btn btn-success">Envoyer</button>
                        </div>
                    </div>

                </form>

            <?php } ?>
                
         </section>
    </div>
</div>