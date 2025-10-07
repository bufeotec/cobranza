<?php
/**
 * Created by PhpStorm
 * User: Franz
 * Date: 20/04/2019
 * Time: 18:25
 */
?>

<br>
<div class="row">
    <div class="col-lg-12">
        <table class="table table-bordered table-hover tabla_servicio" style="border-color: black">
            <thead>
                <tr style="background-color: #ebebeb">
                    <th>ITEM</th>
                    <th>Servicio</th>
                    <th>Cant</th>
                    <th>Precio Unitario</th>
                    <th>Sub Total</th>
                    <th>Accion</th>
                </tr>
            </thead>
            <tbody>
            </tbody>
        </table>
        <div class="row">
            <div class="col-lg-12">
                <div class="row">
                    <div class="col-lg-9" style="text-align: right">
                        <label for="" style="font-size: 14px;">% DESCUENTO GLOBAL</label><br><br>
                        <label for="" style="font-size: 14px;">DESCUENTO GLOBAL (-)</label><br>
                        <label for="" style="font-size: 14px;">DESCUENTO X ITEM (-)</label><br>
                        <label for="" style="font-size: 14px;">DESCUENTO TOTAL (-)</label><br>
                        <?php
                            if($gravada > 0){ ?>
                                <label for="" style="font-size: 14px;">OP. GRAVADAS</label><br>
                                <label for="" style="font-size: 14px;">IGV(18%)</label><br>
                                <?php
                            }
                        ?>

                        <label for="" style="font-size: 14px;">OP. EXONERADAS</label><br>
                        <?php
                        if($inafecta > 0){ ?>
                            <label for="" style="font-size: 14px;">OP. INAFECTAS</label><br>
                            <?php
                        }
                        ?>
                        <label for="" style="font-size: 14px;">OP. GRATUITAS</label><br>
                        <label for="" style="font-size: 14px;">ICBPER</label><br>
                        <label for="" style="font-size: 17px;"><strong>TOTAL</strong></label><br>
                        <label for="" style="font-size: 14px;">PAGÓ CON</label><br>
                        <label for="" style="font-size: 14px;">VUELTO</label>
                    </div>
                    <div class="col-lg-2" style="text-align: right;" >
                        <input style="width: 45%; border-color: #87adbd" onkeyup="calcular_descuento(this.value)" type="text" id="des_global_porcentaje_"><br><br>

                        <label for="" style="font-size: 14px;">0.00</label><br>
                        <label for="" style="font-size: 14px;">0.00</label><br>
                        <label for="" style="font-size: 14px;">0.00</label><br>
                        <label id="idlabeltotalexonerada" for="" style="font-size: 14px;">00.00</label><br>
                        <label for="" style="font-size: 14px;">0.00</label><br>
                        <label for="" style="font-size: 14px;">0.00</label><br>
                        <b><label id="idlabeltotalventa" for="" style="font-size:">0.00</label></b><br>
                        <label for="" style="font-size: 14px;">0.00</label><br>
                        <label for="" style="font-size: 14px;">0.00</label><br>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!--<script type="text/javascript">-->
<!--    function calcular_descuento(valor){-->
<!--        var desc_porcentaje = valor / 100;-->
<!--        var des_item_ = $('#des_item').val() * 1;-->
<!--        var montototal = $('#montototal__').val();-->
<!--        var exonerada = $('#exonerada__').val();-->
<!--        var inafecta = $('#inafecta__').val();-->
<!--        var gravada = $('#gravada__').val();-->
<!---->
<!--        //var montototal = $('#montototal').val();-->
<!--        var desc_total_ = montototal * desc_porcentaje;-->
<!--        var desc_total = desc_total_.toFixed(2);-->
<!--        $('#des_global_').html(desc_total);-->
<!--        $('#des_global').val(desc_total);-->
<!--        var total_descuento = desc_total_ + des_item_;-->
<!--        $('#des_total_').html(total_descuento.toFixed(2));-->
<!--        $('#des_total').val(total_descuento.toFixed(2));-->
<!--        $('#descuento_global').val(desc_porcentaje);-->
<!--        var total_exonerado = 0;-->
<!--        var total_gravada = 0;-->
<!--        var igv = 0;-->
<!--        var total_ = 0;-->
<!--        if(exonerada > 0){-->
<!--            var desc_exonerado_ = exonerada * desc_porcentaje * 1;-->
<!--            var desc_exonerado = exonerada - desc_exonerado_;-->
<!--            total_exonerado = desc_exonerado.toFixed(2);-->
<!--            $('#exonerada_').html(total_exonerado);-->
<!--            $('#exonerada').val(total_exonerado);-->
<!--        }-->
<!--        if(gravada > 0){-->
<!--            var desc_gravada_ = gravada * desc_porcentaje * 1;-->
<!--            var desc_gravada = gravada - desc_gravada_;-->
<!--            total_gravada = desc_gravada.toFixed(2);-->
<!--            var igv_ = desc_gravada * 0.18 ;-->
<!--            igv = igv_.toFixed(2) * 1;-->
<!--            $('#gravada_').html(total_gravada);-->
<!--            $('#gravada').val(total_gravada);-->
<!--            $('#igv_').html(igv);-->
<!--            $('#igv').val(igv);-->
<!--        }-->
<!--        var exo = $('#exonerada').val() * 1;-->
<!--        var gra = $('#gravada').val() * 1;-->
<!--        var ig = $('#igv').val() * 1;-->
<!--        total_ = (exo + gra + ig) * 1;-->
<!--        var total = total_.toFixed(2);-->
<!--        var total = total_.toFixed(2);-->
<!--        $('#montototal_').html(total);-->
<!--        $('#montototal').val(total);-->
<!---->
<!--    }-->
<!--</script>-->