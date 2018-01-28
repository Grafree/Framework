<?php self::_render( 'components/page-header', [ 
                    'title' =>'Ateliers', 
                    'backbtn-display' => true, 
                    'backbtn-url' => '/workshops', 
                    'backbtn-label' => 'Liste des ateliers'
        ] ); ?>

<div class="row">
    <div class="col-md-12">
    
        <?php self::_render( 'components/tabs-toolsheader', [ 
                                'tabs'=>$datas->tabs
                            ] ); ?>
        <section>
            <?php self::_render( 'components/section-toolsheader', [ 
                                'title' => 'Planification de la formation <strong>&laquo; ' . $datas->workshop->TitleWorkshop .' &raquo;</strong>',
                                'subtitle' => ' - Inscription des participants'
                            ] ); ?>
            
            <div class="x_content">
            <br />
                
                <form class="form-horizontal form-label-left" action="<?php echo SITE_URL; ?>/workshops/subscribeupdate/<?php echo $datas->workshop->IdWorkshop; ?>" method="post">
                    
                    <?php self::_render( 'components/form-field', [
                            'title'=>'Inscriptions', 
                            'name'=>'IdUser', 
                            'type'=>'input-checkbox-list', 
                            'options'=>$datas->users,
                            'option-value'=>'value', 
                            'option-label'=>'label'
                    ] ); ?>


                    <div class="form-group">
                        <div class="col-md-9 col-sm-9 col-xs-12 col-md-offset-3">
                            <button type="submit" class="btn btn-success">Inscrire</button>
                        </div>
                    </div>

                </form>

            </div>
          
        </section>
    </div>
</div>


