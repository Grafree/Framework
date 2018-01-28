<?php self::_render( 'components/page-header', [ 
                            'title'             =>'Domaine', 
                            'backbtn-display'   =>true, 
                            'backbtn-url'       =>'/workshops/domains', 
                            'backbtn-label'     =>'Retour aux domaines'
                        ] ); ?>

<div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">

    <?php self::_render( 'components/tabs-toolsheader', [ 
                            'tabs'=>$datas->tabs
                        ] ); ?>
                                
     <section>
                  
    <?php self::_render( 'components/section-toolsheader', [ 
                                        'title'           =>'domaine',
                                        'subtitle'        =>' - Modifier', 
                                        'response'        =>$datas->response
                                    ] ); ?>

        <div class="x_content">
            <br />

            <form action="<?php echo SITE_URL; ?>/workshops/domaineupdate/<?php echo $datas->form->IDDomaine; ?>" method="post" class="form-horizontal form-label-left" enctype="multipart/form-data" >

            <?php self::_render( 'components/form-field', [
                        'title'=>'Nom', 
                        'name'=>'NomDomaine', 
                        'values'=>$datas->form, 
                        'type'=>'input-text', 
                        'required'=>true
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