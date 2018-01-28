<?php self::_render( 'components/page-header', [ 
                        'title'             =>'workshop', 
                        'backbtn-display'   =>true, 
                        'backbtn-url'       =>'/workshops/coaching', 
                        'backbtn-label'     =>'Retour à la liste des formations'
                    ] ); ?>

<div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">

    <?php self::_render( 'components/tabs-toolsheader', [ 
                            'tabs'=>$datas->tabs
                        ] ); ?>
                                
     <section>
                  
    <?php self::_render( 'components/section-toolsheader', [ 
                            'title'           =>'Formations',
                            'subtitle'        =>' - Modifier', 
                            'response'        =>$datas->response
                        ] ); ?>

        <div class="x_content">
            <br />

            <form action="<?php echo SITE_URL; ?>/workshops/workshopupdate/<?php echo $datas->form->IdWorkshop; ?>" method="post" class="form-horizontal form-label-left" enctype="multipart/form-data" >
                            
                
            <?php self::_render( 'components/form-field', [
                                    'title'=>'Nom', 
                                    'name'=>'TitleWorkshop', 
                                    'values'=>$datas->form, 
                                    'type'=>'input-text', 
                                ] ); ?>
                
            <?php self::_render( 'components/form-field', [
                                'title'=>'Domaine', 
                                'name'=>'IdSector', 
                                'values'=>$datas->form, 
                                'type'=>'select',
                                'options'=>$datas->domains,
                                'option-value'=>'value', 
                                'option-label'=>'label',
                            ] ); ?>
                
            <?php self::_render( 'components/form-field', [
                                    'title'=>'Formateur', 
                                    'name'=>'IdCoach', 
                                    'values'=>$datas->form, 
                                    'type'=>'select',
                                    'options'=>$datas->coachs,
                                    'option-value'=>'value', 
                                    'option-label'=>'label',
                                    'option-firstempty'=>true
                                ] ); ?>
                <hr />
                
            <?php self::_render( 'components/form-field', [
                                    'title'=>'Lieu', 
                                    'name'=>'PlaceWorkshop', 
                                    'values'=>$datas->form, 
                                    'type'=>'input-text', 
                                ] ); ?>
            <?php self::_render( 'components/form-field', [
                                    'title'=>'Nb de période', 
                                    'name'=>'NbPeriodsWorkshop', 
                                    'values'=>$datas->form, 
                                    'type'=>'input-text', 
                                ] ); ?>
            <?php self::_render( 'components/form-field', [
                                    'title'=>'Date de démarrage', 
                                    'name'=>'DateStartWorkshop', 
                                    'values'=>$datas->form, 
                                    'type'=>'date', 
                                ] ); ?>
            <?php self::_render( 'components/form-field', [
                                    'title'=>'Date de fin', 
                                    'name'=>'DateEndWorkshop', 
                                    'values'=>$datas->form, 
                                    'type'=>'date', 
                                ] ); ?>
                <hr />
            <?php self::_render( 'components/form-field', [
                        'title'=>'Description', 
                        'name'=>'DescriptionWorkshop', 
                        'values'=>$datas->form, 
                        'type'=>'textarea', 
                ] ); ?>
            <?php self::_render( 'components/form-field', [
                        'title'=>'Prerequis', 
                        'name'=>'PrerequisWorkshop', 
                        'values'=>$datas->form, 
                        'type'=>'textarea', 
                ] ); ?>
            <?php self::_render( 'components/form-field', [
                        'title'=>'Remarques', 
                        'name'=>'RemarquesWorkshop', 
                        'values'=>$datas->form, 
                        'type'=>'textarea', 
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