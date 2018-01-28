<?php self::_render( 'components/page-header', [ 'title' =>'Enquête de la formation' ] ); ?>

<div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
     <section>
                  
    <?php self::_render( 'components/section-toolsheader', [ 
                                        'title'           =>$datas->datas->TitleWorkshop,
                                        'subtitle'        => ' - '. $datas->datas->FirstnameUser . ' ' . $datas->datas->LastnameUser, 
                                        //'response'        =>$datas->response
                                    ] ); ?>

        <div class="clearfix">
            <br />
            <table class="table profile_table">
            <?php 
            
            if( isset( $datas->answers->generals ) ) 
            {
                foreach( $datas->answers->generals as $answer )
                {
                    if( isset( $answer->answer ) )
                    {
                    ?>
                    <tr>
                        <td><?php echo $answer->question->Question; ?> : </td>
                        
                        <td><strong><?php echo ( $answer->answer === 'empty' ) ? 'N\'a pas répondu.' : $answer->answer; ?></strong></td>
                    </tr>
                    <?php
                    }
                    else
                    {
                        ?>
                        <tr>
                            <td colspan="2"><strong><?php echo $answer->question->Question; ?></strong></td>
                        </tr>
                        <?php
                    }
                }
            }
            ?>
            </table>    
            
            
            <h3>Plus spécifiquement</h3>
            
            <table class="table profile_table">
            <?php
            if( isset( $datas->answers->specifics ) ) 
            {
                foreach( $datas->answers->specifics as $answer )
                {
                    if( isset( $answer->answer ) )
                    {
                    ?>
                    <tr>
                        <td><?php echo $answer->question->Question; ?> : </td>
                        
                        <td><strong><?php echo ( $answer->answer === 'empty' ) ? 'N\'a pas répondu.' : $answer->answer; ?></strong></td>
                    </tr>
                    <?php
                    }
                    else
                    {
                        ?>
                        <tr>
                            <td colspan="2"><strong><?php echo $answer->question->Question; ?></strong></td>
                        </tr>
                        <?php
                    }
                    
                }
            }
            ?>
            </table>
         </section>
    </div>
</div>