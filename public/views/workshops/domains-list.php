<?php self::_render( 'components/page-header', [ 'title' =>'Domaines' ] ); ?>

<div class="row">
    <div class="col-md-12">
    
        <?php self::_render( 'components/tabs-toolsheader', [ 
                                'tabs'=>$datas->tabs
                            ] ); ?>
        <section>
            <?php self::_render( 'components/section-toolsheader', [ 
                                'title' => 'Domaines',
                                'subtitle' => '', 
                                'tool-add' => true,
                                'tool-add-right' => 'add',
                                'tool-add-url' => '/workshops/domaineform/',
                                'tool-add-label' => 'Ajouter un domaine',
                                'rightpage' => 'users',
                                'response' => $datas->response
                            ] ); ?>
            
            <div class="body-section"> 
                
            <?php
            if( isset( $datas->datas ) )
            {
                foreach( $datas->datas as $n => $data )
                {       
                    ?>
                    <section class="profile clearfix">
                        <?php self::_render( 'components/section-toolsheader', [ 
                                            'title' => '<a href="'.SITE_URL.'/workshops/detail/'.$data->IDDomaine.'">'.$data->NomDomaine.'</a>',
                                            'subtitle' => '', 
                                            'tool-update' => true,
                                            'tool-update-url' => '/workshops/domaineform/' . $data->IDDomaine,
                                            'tool-delete' => true,
                                            'tool-delete-url' => '/workshops/domainedelete/' . $data->IDDomaine,
                                            'tool-delete-display' => !$data->infos['hasDependencies'],
                                            'rightpage'=>'users',
                                            'alertbox-display' => false
                                        ] ); ?>

                    </section>
                    <?php
                }
            }
            else
            {
                ?>
                <p class="alert alert-info">Aucun domaine trouvé !</p>
                <?php
            }
        ?>
        </div>
                    
                    
<?php self::_render( 'components/window-modal', [ 
                            'idname'=>'delete', 
                            'title'=>'Suppression d\'un domaine', 
                            'content'=>'Etes-vous sûr de vouloir supprimer un domaine ?', 
                            'submitbtn' => 'Supprimer' 
                        ] ); ?>
        </section>
    </div>
</div>