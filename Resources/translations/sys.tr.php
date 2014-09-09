<?php
/**
 * sys.tr.php
 *
 * Bu dosya ilgili paketin sistem (hata ve başarı) mesajlarını Türkçe olarak barındırır.
 *
 * @vendor      BiberLtd
 * @package		Core\Bundles\SiteManagementBundle
 * @subpackage	Resources
 * @name	    sys.tr.php
 *
 * @author		Can Berkol
 *
 * @copyright   Biber Ltd. (www.biberltd.com)
 *
 * @version     1.0.0
 * @date        03.08.2013
 *
 * =============================================================================================================
 * !!! ÖNEMLİ !!!
 *
 * Çalıştığınız sunucu ortamına göre Symfony ön belleğini temizlemek için işbu dosyayı her değiştirişinizden sonra
 * aşağıdaki komutu çalıştırmalısınız veya app/cache klasörünü silmelisiniz. Aksi takdir de tercümelerde
 * yapmış olduğunuz değişiklikler işleme alıalınmayacaktır.
 *
 * $ sudo -u apache php app/console cache:clear
 * VEYA
 * $ php app/console cache:clear
 * =============================================================================================================
 * TODOs:
 * Yok
 */
/** İçiçe anahtar tanımlaması yapabilirsiniz */
return array(
    /** Hata mesajları */
    'err'       => array(
        /** Site Management Model */
        'smm'   => array(
            'duplicate_site'            => 'Veri tabanında aynı id veya url_key değerine sahip başka bir site kaydı bulunuyor.',
            'invalid_parameter'         => 'Metoda hatalı bir parametre gönderildi. Parametrenin metod açıklamalarına uygun olduğundan emin olun.',
            'invalid_site_collection'   => 'Silinmesi istenen Site objelerini veya site tanımlama numaralarını bir dizi içerisinde göndermelisiniz.',
            'invalid_site_sort_order'   => 'Sıralama dizisinin method açıklamalarında belirtildiği şekilde hazırlandığından emin olun.',
            'not_found'                 => 'Aradığınız site/siteler veri tabanında bulunamadı.',
            'unknown'                   => 'Bilinmeyen bir hata oluştu veya SiteManagementModel objesi yaratılamadı.',
        ),
    ),
    /** Başarı mesajları */
    'scc'       => array(
        /** Site Management Model */
        'smm'   => array(
            'default'                   => 'Veri tabanına gönderilen işlem başarıyla tamamlandı.',
            'deleted'                   => 'Seçili siteler veri tabanından başarıyla silinmiştir.',
            'inserted_multiple'         => 'Veriler, veri tabanına başarıyla eklendi.',
            'inserted_single'           => 'Veri, veri tabanına başarıyla eklendi.',
            'updated_multiple'          => 'Veriler başarıyla güncellendi.',
            'updated_single'            => 'Veri başarıyla güncellendi.',
        ),
    ),
);
/**
 * Change Log / Değişiklik Kaydı
 * **************************************
 * v1.0.0                      Can Berkol
 * 03.08.2013
 * **************************************
 * A err
 * A err.smm
 * A err.smm.unknown
 * A scc
 * A scc.smm
 * A scc.smm.default
 */