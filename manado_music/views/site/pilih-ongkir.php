<?php
use yii\helpers\Html;
use yii\helpers\Url;
use yii\helpers\ArrayHelper;

  if(@fopen("https://www.google.com", "r")) {
    $response_ongkir = $client->createRequest()
        ->setHeaders([
            'key' => '342a8e29cf24c23aeeb403cc6f336fb5',
          ])
        ->setMethod('POST')
        ->setUrl('https://api.rajaongkir.com/starter/cost')
        ->setData([
          'origin' => '54',
          'destination' => $destination,
          'weight' => $berat,
          'courier' => $kurir
        ])
        ->send();
    $data_ongkir = $response_ongkir->data;
    $data_ongkir_list = $data_ongkir['rajaongkir']['results']['0']['costs'];
    // $data_ongkir_list = $data_ongkir;
    // echo "<pre>";
    // print_r($data_ongkir);
    // echo "</pre>";
  }
?>
<style>
#konfirmasi-jasa label{
  display:flex;
}
#konfirmasi-jasa label input{
  margin-right:5px;
}
</style>

<?= $form->field($model, 'jasa')->radioList(ArrayHelper::map($data_ongkir_list,"service",function($data_ongkir_list){
  $hari = "Hari : ".$data_ongkir_list['cost']['0']['etd'];
  $ongkir = $data_ongkir_list['cost']['0']['value'];
  return "Rp. ".number_format($ongkir,2,',','.')." - ".$hari;
}),['class'=>'radio-left','role'=>"radiogroup"])->label(); ?>
