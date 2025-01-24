<?php
/*
=====================================================
 DataLife Engine - by SoftNews Media Group
-----------------------------------------------------
 http://dle-news.ru/
-----------------------------------------------------
 Copyright (c) 2004-2021 SoftNews Media Group
=====================================================
 This code is protected by copyright
=====================================================
*/

ob_start();
ob_implicit_flush(0);

$strMapRedir = <<<TEXT
/katalog/:/turbiny/
/legkovye-masiny/audi/*:/turbiny/5/
/legkovye-masiny/land-rover/*:/turbiny/1820/
/legkovye-masiny/bmw/*:/turbiny/16/
/legkovye-masiny/volkswagen/*:/turbiny/121/
/legkovye-masiny/mercedes/*:/turbiny/74/
/legkovye-masiny/volvo/*:/turbiny/120/
/legkovye-masiny/alfa-romeo/*:/turbiny/2/
/legkovye-masiny/chevrolet/*:/turbiny/138/
/legkovye-masiny/citroen/*:/turbiny/21/
/legkovye-masiny/fiat/*:/turbiny/35/
/legkovye-masiny/ford/*:/turbiny/36/
/legkovye-masiny/honda/*:/turbiny/45/
/legkovye-masiny/hyundai/*:/turbiny/183/
/legkovye-masiny/jaguar/*:/turbiny/56/
/legkovye-masiny/jeep/*:/turbiny/882/
/legkovye-masiny/mazda/*:/turbiny/72/
/legkovye-masiny/smart/*:/turbiny/1138/
/legkovye-masiny/mini/*:/turbiny/1523/
/legkovye-masiny/mitsubishi/*:/turbiny/77/
/legkovye-masiny/nissan/*:/turbiny/80/
/legkovye-masiny/opel/*:/turbiny/84/
/legkovye-masiny/peugeot/*:/turbiny/88/
/legkovye-masiny/renault/*:/turbiny/93/
/legkovye-masiny/saab/*:/turbiny/99/
/legkovye-masiny/ssangyong/*:/turbiny/175/
/legkovye-masiny/seat/*:/turbiny/104/
/legkovye-masiny/skoda/*:/turbiny/106/
/legkovye-masiny/subaru/*:/turbiny/107/
/legkovye-masiny/toyota/*:/turbiny/111/
/legkovye-masiny/bentley/*:/turbiny/815/
/legkovye-masiny/porshe/*:/turbiny/92/
/legkovye-masiny/kia/*:/turbiny/184/
/montazdemontaz-turbin/:/uslugi/16-montazh-demontazh-turbin.html
/zamena-ili-remont-aktuatora/:/uslugi/17-zamena-ili-remont-aktuatora.html
/diagnostika-turbiny/:/uslugi/18-diagnostika-turbiny.html
/vosstanovlenie-rezbovyh-otverstij/:/uslugi/19-vosstanovlenie-rezbovyh-otverstij-v-turbinah.html
/cip-tuning-lubyh-marok-avtomobilej/:/uslugi/20-chip-tjuning-ljubyh-marok-avtomobilej.html
/remont-turbin-dizelnyh-dvigatelej/:/uslugi/21-remont-turbin-dizelnyh-dvigatelej.html
/uslugi/22-prodazha-kartridzhej.html://ee-turbosklad.ru/kartridzh-turbiny/
/prodaza-kartridzej/://ee-turbosklad.ru/kartridzh-turbiny/
/remont-turbin-garrett/:/uslugi/23-remont-turbin-garrett.html
/remont-turbin-caterpillar/:/uslugi/24-remont-turbin-caterpillar.html
/remont-klapana-vestgeyta/:/uslugi/25-remont-klapana-vestgejta.html
/o-kompanii/:/o-kompanii.html
/sotrudnichestvo/:/sotrudnichestvo.html
/catalog/video/:/video/
/kontakty/:/kontakty.html
/turbiny/parts/107871/2234/*:/catalog_auto/FORD/FORD_FOCUS/
/turbiny/parts/120842/2234/*:/catalog_auto/KIA/KIA_OPTIMA/
/turbiny/parts/109947/2234/*:/catalog_auto/KIA/KIA_SORENTO/
/turbiny/parts/29493/2234/*:/catalog_auto/TOYOTA/TOYOTA_LAND_CRUISER/
/turbiny/parts/58759/2234/*:/catalog_auto/SKODA/SKODA_OCTAVIA/
/turbiny/parts/25498/2234/*:/catalog_auto/BMW/BMW_X5/
/turbiny/parts/32088/2234/*:/catalog_auto/OPEL/OPEL_ASTRA/
/turbiny/parts/23181/2234/*:/catalog_auto/VOLKSWAGEN/VOLKSWAGEN_TIGUAN/
/turbiny/parts/126646/2234/*:/catalog_auto/OPEL/OPEL_ASTRA/
/turbiny/parts/107967/2234/*:/catalog_auto/FORD/FORD_KUGA/
/turbiny/parts/7867/2234/*:/catalog_auto/SKODA/SKODA_OCTAVIA/
/turbiny/parts/108072/2234/*:/catalog_auto/FORD/FORD_KUGA/
/turbiny/parts/34758/2234/*:/catalog_auto/NISSAN/NISSAN_PATHFINDER/
/turbiny/parts/113440/2234/*:/catalog_auto/BMW/BMW_3ER/
/turbiny/parts/117389/2234/*:/catalog_auto/LEXUS/LEXUS_RX/
/turbiny/parts/123308/2234/*:/catalog_auto/TOYOTA/TOYOTA_LAND_CRUISER_PRADO/
/turbiny/parts/33582/2234/*:/catalog_auto/INFINITI/INFINITI_FX/
/turbiny/parts/116058/2234/*:/catalog_auto/AUDI/AUDI_Q5/
/turbiny/parts/26913/2234/*:/catalog_auto/AUDI/AUDI_A4/
/turbiny/parts/9491/2234/*:/catalog_auto/SKODA/SKODA_YETI/
/turbiny/parts/23196/2234/*:/catalog_auto/NISSAN/NISSAN_X_TRAIL/
/turbiny/parts/131420/2234/*:/catalog_auto/BMW/BMW_X5/
/turbiny/parts/55254/2234/*:/catalog_auto/BMW/BMW_X6/
/turbiny/parts/106464/2234/*:/catalog_auto/NISSAN/NISSAN_X_TRAIL/
/turbiny/parts/34724/2234/*:/catalog_auto/NISSAN/NISSAN_JUKE/
/turbiny/parts/57472/2234/*:/catalog_auto/BMW/BMW_3ER/
/turbiny/parts/32750/2234/*:/catalog_auto/SKODA/SKODA_YETI/
/turbiny/parts/113408/2234/*:/catalog_auto/BMW/BMW_3ER/
/turbiny/parts/121220/2234/*:/catalog_auto/TOYOTA/TOYOTA_C_HR/
/turbiny/parts/100721/2234/*:/catalog_auto/INFINITI/INFINITI_QX70/
/turbiny/parts/107545/2234/*:/catalog_auto/PORSCHE/PORSCHE_CAYENNE/
/turbiny/parts/4960/2234/*:/catalog_auto/KIA/KIA_SPORTAGE/
/turbiny/parts/114609/2234/*:/catalog_auto/HYUNDAI/HYUNDAI_TUCSON/
/turbiny/parts/10311/2234/*:/catalog_auto/BMW/BMW_1ER/
/turbiny/parts/12470/2234/*:/catalog_auto/BMW/BMW_3ER/
/turbiny/parts/131767/2234/*:/catalog_auto/KIA/KIA_CEED/
/turbiny/parts/31501/2234/*:/catalog_auto/MERCEDES/MERCEDES_C_KLASSE/
/turbiny/parts/34960/2234/*:/catalog_auto/HYUNDAI/HYUNDAI_SANTA_FE/
/turbiny/parts/5929/2234/*:/catalog_auto/SKODA/SKODA_SUPERB/
/turbiny/parts/101045/2234/*:/catalog_auto/BMW/BMW_X3/
/turbiny/parts/123823/2234/*:/catalog_auto/BMW/BMW_5ER/
/turbiny/parts/29996/2234/*:/catalog_auto/VOLKSWAGEN/VOLKSWAGEN_TIGUAN/
/turbiny/parts/50842/2234/*:/catalog_auto/MAZDA/MAZDA_CX_5/
/turbiny/parts/114063/2234/*:/catalog_auto/BMW/BMW_7ER/
/turbiny/parts/55481/2234/*:/catalog_auto/AUDI/AUDI_A3/
/turbiny/parts/100477/2234/*:/catalog_auto/MERCEDES/MERCEDES_GLA_CLASS/
/turbiny/parts/109270/2234/*:/catalog_auto/OPEL/OPEL_INSIGNIA/
/turbiny/parts/119122/2234/*:/catalog_auto/HYUNDAI/HYUNDAI_TUCSON/
/turbiny/parts/19070/2234/*:/catalog_auto/NISSAN/NISSAN_X_TRAIL/
/turbiny/parts/33012/2234/*:/catalog_auto/BMW/BMW_5ER/
/turbiny/parts/59252/2234/*:/catalog_auto/OPEL/OPEL_INSIGNIA/
/turbiny/parts/11461/2234/*:/catalog_auto/JEEP/JEEP_GRAND_CHEROKEE/
/turbiny/parts/1620/2234/*:/catalog_auto/NISSAN/NISSAN_NP300/
/turbiny/parts/2483/2234/*:/catalog_auto/LAND_ROVER/LAND_ROVER_RANGE_ROVER/
/turbiny/parts/33042/2234/*:/catalog_auto/DACIA/DACIA_DUSTER/
/turbiny/parts/58546/2234/*:/catalog_auto/FORD/FORD_KUGA/
/turbiny/parts/10292/2234/*:/catalog_auto/VOLVO/VOLVO_XC60/
/turbiny/parts/123427/2234/*:/catalog_auto/SKODA/SKODA_KODIAQ/
/turbiny/parts/57293/2234/*:/catalog_auto/BMW/BMW_3ER/
/turbiny/parts/113405/2234/*:/catalog_auto/BMW/BMW_3ER/
/turbiny/parts/31058/2234/*:/catalog_auto/NISSAN/NISSAN_QASHQAI/
/turbiny/parts/5985/2234/*:/catalog_auto/MITSUBISHI/MITSUBISHI_CARISMA/
/turbiny/parts/130236/2234/*:/catalog_auto/LEXUS/LEXUS_RX/
/turbiny/parts/117977/2234/*:/catalog_auto/PORSCHE/PORSCHE_MACAN/
/turbiny/parts/121989/2234/*:/catalog_auto/INFINITI/INFINITI_Q60/
/turbiny/parts/122024/2234/*:/catalog_auto/TOYOTA/TOYOTA_C_HR/
/turbiny/parts/19708/2234/*:/catalog_auto/FORD/FORD_S_MAX/
/turbiny/parts/22460/2234/*:/catalog_auto/MERCEDES/MERCEDES_C_KLASSE/
/turbiny/parts/29992/2234/*:/catalog_auto/VOLKSWAGEN/VOLKSWAGEN_GOLF/
/turbiny/parts/32089/2234/*:/catalog_auto/OPEL/OPEL_ASTRA/
/turbiny/parts/57459/2234/*:/catalog_auto/VOLKSWAGEN/VOLKSWAGEN_GOLF/
/turbiny/parts/58825/2234/*:/catalog_auto/OPEL/OPEL_ZAFIRA/
/turbiny/parts/58984/2234/*:/catalog_auto/VOLKSWAGEN/VOLKSWAGEN_TOUAREG/
/turbiny/parts/31592/2234/*:/catalog_auto/SKODA/SKODA_OCTAVIA/
/turbiny/parts/33308/2234/*:/catalog_auto/VOLKSWAGEN/VOLKSWAGEN_TOUAREG/
/turbiny/parts/361/2234/*:/catalog_auto/VOLKSWAGEN/VOLKSWAGEN_PASSAT/
/turbiny/parts/53100/2234/*:/catalog_auto/BMW/BMW_X6/
/turbiny/parts/19506/2234/*:/catalog_auto/KIA/KIA_SORENTO/
/turbiny/parts/27620/2234/*:/catalog_auto/VOLVO/VOLVO_S80/
/turbiny/parts/100271/2234/*:/catalog_auto/BMW/BMW_X5/
/turbiny/parts/106657/2234/*:/catalog_auto/VOLKSWAGEN/VOLKSWAGEN_PASSAT/
/turbiny/parts/32166/2234/*:/catalog_auto/MERCEDES/MERCEDES_M_KLASSE/
/turbiny/parts/100528/2234/*:/catalog_auto/VOLVO/VOLVO_S60/
/turbiny/parts/11458/2234/*:/catalog_auto/JEEP/JEEP_GRAND_CHEROKEE/
/turbiny/parts/12258/2234/*:/catalog_auto/HYUNDAI/HYUNDAI_IX55/
/turbiny/parts/16040/2234/*:/catalog_auto/AUDI/AUDI_A4/
/turbiny/parts/4736/2234/*:/catalog_auto/BMW/BMW_5ER/
/turbiny/parts/908/2234/*:/catalog_auto/OPEL/OPEL_ASTRA/
/turbiny/parts/100903/2234/*:/catalog_auto/MERCEDES/MERCEDES_C_KLASSE/
/turbiny/parts/110061/2234/*:/catalog_auto/BMW/BMW_1ER/
/turbiny/parts/116340/2234/*:/catalog_auto/MITSUBISHI/MITSUBISHI_MONTERO_SPORT/
/turbiny/parts/58764/2234/*:/catalog_auto/SKODA/SKODA_OCTAVIA/
/turbiny/parts/115131/2234/*:/catalog_auto/JAGUAR/JAGUAR_XF/
/turbiny/parts/117077/2234/*:/catalog_auto/AUDI/AUDI_A4/
/turbiny/parts/118592/2234/*:/catalog_auto/KIA/KIA_SPORTAGE/
/turbiny/parts/119044/2234/*:/catalog_auto/BMW/BMW_X3/
/turbiny/parts/121918/2234/*:/catalog_auto/BMW/BMW_3ER/
/turbiny/parts/123422/2234/*:/catalog_auto/SKODA/SKODA_KODIAQ/
/turbiny/parts/128221/2234/*:/catalog_auto/LAND_ROVER/LAND_ROVER_EVOQUE/
/turbiny/parts/18259/2234/*:/catalog_auto/SSANG_YONG/SSANG_YONG_REXTON/
/turbiny/74/*:/catalog_auto/MERCEDES/
/turbiny/74/11184/*:/catalog_auto/MERCEDES/MERCEDES_GL_KLASSE/
/turbiny/74/36202/*:/catalog_auto/MERCEDES/MERCEDES_E_KLASSE/
/turbiny/74/9769/*:/catalog_auto/MERCEDES/MERCEDES_B_KLASSE/
/turbiny/74/8034/*:/catalog_auto/MERCEDES/MERCEDES_E_KLASSE/
/turbiny/74/5521/*:/catalog_auto/MERCEDES/MERCEDES_GL_KLASSE/
/turbiny/74/5012/*:/catalog_auto/MERCEDES/MERCEDES_VIANO/
/turbiny/74/9800/*:/catalog_auto/MERCEDES/MERCEDES_M_KLASSE/
/turbiny/74/14799/*:/catalog_auto/MERCEDES/MERCEDES_GLS_KLASSE/
/turbiny/74/7580/*:/catalog_auto/MERCEDES/MERCEDES_GLK_KLASSE/
/turbiny/74/5415/*:/catalog_auto/MERCEDES/MERCEDES_M_KLASSE/
/turbiny/74/11889/*:/catalog_auto/MERCEDES/MERCEDES_V_KLASSE/
/turbiny/74/6224/*:/catalog_auto/MERCEDES/MERCEDES_C_KLASSE/
/turbiny/74/14305/*:/catalog_auto/MERCEDES/MERCEDES_GLC_KLASSE/
/turbiny/74/10342/*:/catalog_auto/MERCEDES/MERCEDES_A_KLASSE/
/turbiny/74/65/*:/catalog_auto/MERCEDES/MERCEDES_G_KLASSE/
/turbiny/74/11851/*:/catalog_auto/MERCEDES/MERCEDES_C_KLASSE/
/turbiny/74/5455/*:/catalog_auto/MERCEDES/MERCEDES_S_KLASSE/
/turbiny/74/13966/*:/catalog_auto/MERCEDES/MERCEDES_GLE_KLASSE/
/turbiny/74/11050/*:/catalog_auto/MERCEDES/MERCEDES_CLA_KLASSE/
/turbiny/74/3575/*:/catalog_auto/MERCEDES/MERCEDES_S_KLASSE/
/turbiny/74/5463/*:/catalog_auto/MERCEDES/MERCEDES_R_KLASSE/
/turbiny/1820/*:/catalog_auto/LAND_ROVER/
/turbiny/1820/5603/*:/catalog_auto/LAND_ROVER/LAND_ROVER_FREELANDER/
/turbiny/1820/9015/*:/catalog_auto/LAND_ROVER/LAND_ROVER_DISCOVERY/
/turbiny/1820/5160/*:/catalog_auto/LAND_ROVER/LAND_ROVER_DISCOVERY/
/turbiny/1820/4869/*:/catalog_auto/LAND_ROVER/LAND_ROVER_RANGE_ROVER/
/turbiny/1820/37713/*:/catalog_auto/LAND_ROVER/LAND_ROVER_RANGE_ROVER_VELAR/
/turbiny/1820/14820/*:/catalog_auto/LAND_ROVER/LAND_ROVER_EVOQUE/
/turbiny/1820/13104/*:/catalog_auto/LAND_ROVER/LAND_ROVER_DISCOVERY_SPORT/
/turbiny/1820/5437/*:/catalog_auto/LAND_ROVER/LAND_ROVER_RANGE_ROVER_SPORT/
/turbiny/1820/10810/*:/catalog_auto/LAND_ROVER/LAND_ROVER_RANGE_ROVER/
/turbiny/1820/9576/*:/catalog_auto/LAND_ROVER/LAND_ROVER_EVOQUE/
/turbiny/1820/11229/*:/catalog_auto/LAND_ROVER/LAND_ROVER_RANGE_ROVER_SPORT/
/turbiny/16/*:/catalog_auto/BMW/
/turbiny/16/7378/*:/catalog_auto/BMW/BMW_X6/
/turbiny/16/6414/*:/catalog_auto/BMW/BMW_X5/
/turbiny/16/8763/*:/catalog_auto/BMW/BMW_X3/
/turbiny/16/8541/*:/catalog_auto/BMW/BMW_5ER/
/turbiny/16/9831/*:/catalog_auto/BMW/BMW_3ER/
/turbiny/16/12845/*:/catalog_auto/BMW/BMW_X6/
/turbiny/16/37157/*:/catalog_auto/BMW/BMW_5ER/
/turbiny/16/11482/*:/catalog_auto/BMW/BMW_X5/
/turbiny/16/38751/*:/catalog_auto/BMW/BMW_X5/
/turbiny/16/4343/*:/catalog_auto/BMW/BMW_X5/
/turbiny/106/*:/catalog_auto/SKODA/
/turbiny/106/11195/*:/catalog_auto/SKODA/SKODA_OCTAVIA/
/turbiny/106/7588/*:/catalog_auto/SKODA/SKODA_SUPERB/
/turbiny/106/10587/*:/catalog_auto/SKODA/SKODA_RAPID/
/turbiny/106/8486/*:/catalog_auto/SKODA/SKODA_YETI/
/turbiny/106/38149/*:/catalog_auto/SKODA/SKODA_KAROQ/
/turbiny/36/*:/catalog_auto/FORD/
/turbiny/36/6238/*:/catalog_auto/FORD/FORD_MONDEO/
/turbiny/36/11097/*:/catalog_auto/FORD/FORD_KUGA/
/turbiny/36/5210/*:/catalog_auto/FORD/FORD_FOCUS/
/turbiny/36/4933/*:/catalog_auto/FORD/FORD_TOURNEO_CONNECT/
/turbiny/36/7367/*:/catalog_auto/FORD/FORD_KUGA/
/turbiny/36/5542/*:/catalog_auto/FORD/FORD_S_MAX/
/turbiny/36/11947/*:/catalog_auto/FORD/FORD_TRANSIT/
/turbiny/36/13129/*:/catalog_auto/FORD/FORD_MONDEO/
/turbiny/80/*:/catalog_auto/NISSAN/
/turbiny/80/5395/*:/catalog_auto/NISSAN/NISSAN_PATHFINDER/
/turbiny/80/5616/*:/catalog_auto/NISSAN/NISSAN_QASHQAI/
/turbiny/80/3880/*:/catalog_auto/NISSAN/NISSAN_PATROL/
/turbiny/80/6399/*:/catalog_auto/NISSAN/NISSAN_X_TRAIL/
/turbiny/80/11226/*:/catalog_auto/NISSAN/NISSAN_NOTE/
/turbiny/80/12857/*:/catalog_auto/NISSAN/NISSAN_X_TRAIL/
/turbiny/121/*:/catalog_auto/VOLKSWAGEN/
/turbiny/121/6397/*:/catalog_auto/VOLKSWAGEN/VOLKSWAGEN_TIGUAN/
/turbiny/121/14349/*:/catalog_auto/VOLKSWAGEN/VOLKSWAGEN_MULTIVAN/
/turbiny/121/7375/*:/catalog_auto/VOLKSWAGEN/VOLKSWAGEN_PASSAT_CC/
/turbiny/121/10585/*:/catalog_auto/VOLKSWAGEN/VOLKSWAGEN_GOLF/
/turbiny/121/4920/*:/catalog_auto/VOLKSWAGEN/VOLKSWAGEN_TOUAREG/
/turbiny/121/8636/*:/catalog_auto/VOLKSWAGEN/VOLKSWAGEN_AMAROK/
/turbiny/121/1312/*:/catalog_auto/VOLKSWAGEN/VOLKSWAGEN_SHARAN/
/turbiny/121/4954/*:/catalog_auto/VOLKSWAGEN/VOLKSWAGEN_TOURAN/
/turbiny/120/*:/catalog_auto/VOLVO/
/turbiny/120/7583/*:/catalog_auto/VOLVO/VOLVO_XC60/
/turbiny/120/4879/*:/catalog_auto/VOLVO/VOLVO_XC90/
/turbiny/120/8616/*:/catalog_auto/VOLVO/VOLVO_S60/
/turbiny/120/6391/*:/catalog_auto/VOLVO/VOLVO_XC70/
/turbiny/5/*:/catalog_auto/AUDI/
/turbiny/5/7534/*:/catalog_auto/AUDI/AUDI_Q5/
/turbiny/5/9731/*:/catalog_auto/AUDI/AUDI_Q3/
/turbiny/5/5461/*:/catalog_auto/AUDI/AUDI_Q7/
/turbiny/5/9154/*:/catalog_auto/AUDI/AUDI_A6/
/turbiny/5/6418/*:/catalog_auto/AUDI/AUDI_A4/
/turbiny/183/*:/catalog_auto/HYUNDAI/
/turbiny/183/14316/*:/catalog_auto/HYUNDAI/HYUNDAI_TUCSON/
/turbiny/183/1988/*:/catalog_auto/HYUNDAI/HYUNDAI_H_1_STAREX/
/turbiny/183/8056/*:/catalog_auto/HYUNDAI/HYUNDAI_IX55/
/turbiny/183/4712/*:/catalog_auto/HYUNDAI/HYUNDAI_SANTA_FE/
/turbiny/183/10515/*:/catalog_auto/HYUNDAI/HYUNDAI_SANTA_FE/
/turbiny/183/38591/*:/catalog_auto/HYUNDAI/HYUNDAI_SANTA_FE/
/turbiny/183/5600/*:/catalog_auto/HYUNDAI/HYUNDAI_SANTA_FE/
/turbiny/84/*:/catalog_auto/OPEL/
/turbiny/84/5548/*:/catalog_auto/OPEL/OPEL_ANTARA/
/turbiny/84/7581/*:/catalog_auto/OPEL/OPEL_INSIGNIA/
/turbiny/84/8549/*:/catalog_auto/OPEL/OPEL_MERIVA/
/turbiny/84/9717/*:/catalog_auto/OPEL/OPEL_ZAFIRA/
/turbiny/84/14870/*:/catalog_auto/OPEL/OPEL_ASTRA/
/turbiny/175/*:/catalog_auto/SSANG_YONG/
/turbiny/175/5484/*:/catalog_auto/SSANG_YONG/SSANG_YONG_KYRON/
/turbiny/175/38246/*:/catalog_auto/SSANG_YONG/SSANG_YONG_REXTON/
/turbiny/184/*:/catalog_auto/KIA/
/turbiny/184/5604/*:/catalog_auto/KIA/KIA_CARNIVAL/
/turbiny/184/8258/*:/catalog_auto/KIA/KIA_SORENTO/
/turbiny/184/38141/*:/catalog_auto/KIA/KIA_STINGER/
/turbiny/184/8751/*:/catalog_auto/KIA/KIA_SPORTAGE/
/turbiny/184/13620/*:/catalog_auto/KIA/KIA_SORENTO/
/turbiny/111/*:/catalog_auto/TOYOTA/
/turbiny/111/7806/*:/catalog_auto/TOYOTA/TOYOTA_LAND_CRUISER/
/turbiny/111/3566/*:/catalog_auto/TOYOTA/TOYOTA_LAND_CRUISER/
/turbiny/111/198/*:/catalog_auto/TOYOTA/TOYOTA_LAND_CRUISER/
/turbiny/111/8657/*:/catalog_auto/TOYOTA/TOYOTA_LAND_CRUISER_PRADO/
/turbiny/93/*:/catalog_auto/RENAULT/
/turbiny/93/11776/*:/catalog_auto/RENAULT/RENAULT_TALISMAN/
/turbiny/93/5133/*:/catalog_auto/RENAULT/RENAULT_SCENIC/
/turbiny/93/6431/*:/catalog_auto/RENAULT/RENAULT_LAGUNA/
/turbiny/93/13881/*:/catalog_auto/RENAULT/RENAULT_KADJAR/
/turbiny/93/8148/*:/catalog_auto/RENAULT/RENAULT_SCENIC/
/turbiny/93/13882/*:/catalog_auto/RENAULT/RENAULT_ESPACE/
/turbiny/93/5071/*:/catalog_auto/RENAULT/RENAULT_MEGANE/
/turbiny/21/*:/catalog_auto/CITROEN/
/turbiny/72/*:/catalog_auto/MAZDA/
/turbiny/72/6435/*:/catalog_auto/MAZDA/MAZDA_CX_7/
/turbiny/72/13892/*:/catalog_auto/MAZDA/MAZDA_CX_3/
/turbiny/88/*:/catalog_auto/PEUGEOT/
/turbiny/88/7997/*:/catalog_auto/PEUGEOT/PEUGEOT_3008/
/turbiny/88/5642/*:/catalog_auto/PEUGEOT/PEUGEOT_EXPERT/
/turbiny/88/6738/*:/catalog_auto/PEUGEOT/PEUGEOT_PARTNER/
/turbiny/882/*:/catalog_auto/JEEP/
/turbiny/882/9072/*:/catalog_auto/JEEP/JEEP_GRAND_CHEROKEE/
/turbiny/882/38535/*:/catalog_auto/JEEP/JEEP_WRANGLER/
/turbiny/882/13019/*:/catalog_auto/JEEP/JEEP_RENEGADE/
/turbiny/882/7574/*:/catalog_auto/JEEP/JEEP_WRANGLER/
/turbiny/138/*:/catalog_auto/CHEVROLET/
/turbiny/138/5597/*:/catalog_auto/CHEVROLET/CHEVROLET_CAPTIVA/
/turbiny/138/10003/*:/catalog_auto/CHEVROLET/CHEVROLET_MALIBU/
/turbiny/138/10819/*:/catalog_auto/CHEVROLET/CHEVROLET_TRAX/
/turbiny/77/*:/catalog_auto/MITSUBISHI/
/turbiny/77/6248/*:/catalog_auto/MITSUBISHI/MITSUBISHI_PAJERO/
/turbiny/77/5524/*:/catalog_auto/MITSUBISHI/MITSUBISHI_L200/
/turbiny/77/1555/*:/catalog_auto/MITSUBISHI/MITSUBISHI_L200/
/turbiny/77/38273/*:/catalog_auto/MITSUBISHI/MITSUBISHI_ECLIPSE_CROSS/
/turbiny/77/4015/*:/catalog_auto/MITSUBISHI/MITSUBISHI_PAJERO_SPORT/
/turbiny/1526/*:/catalog_auto/INFINITI/
/turbiny/1526/11419/*:/catalog_auto/INFINITI/INFINITI_Q50/
/turbiny/1526/11858/*:/catalog_auto/INFINITI/INFINITI_QX70/
/turbiny/45/*:/catalog_auto/HONDA/
/turbiny/45/37515/*:/catalog_auto/HONDA/HONDA_CIVIC/
/turbiny/35/*:/catalog_auto/FIAT/
/turbiny/1138/*:/catalog_auto/SMART/
/turbiny/109/*:/catalog_auto/SUZUKI/
/turbiny/109/3972/*:/catalog_auto/SUZUKI/SUZUKI_JIMNY/
/turbiny/109/13638/*:/catalog_auto/SUZUKI/SUZUKI_VITARA/
/turbiny/1523/*:/catalog_auto/MINI/
/turbiny/1523/11753/*:/catalog_auto/MINI/
/turbiny/1523/7996/*:/catalog_auto/MINI/
/turbiny/1523/37158/*:/catalog_auto/MINI/MINI_COUNTRYMAN/
/turbiny/56/*:/catalog_auto/JAGUAR/
/turbiny/56/14864/*:/catalog_auto/JAGUAR/JAGUAR_F_PACE/
/turbiny/55/*:/catalog_auto/IVECO/
/turbiny/842/*:/catalog_auto/LEXUS/
/turbiny/842/14797/*:/catalog_auto/LEXUS/LEXUS_RX/
/turbiny/842/10095/*:/catalog_auto/LEXUS/LEXUS_GS/
/turbiny/842/12998/*:/catalog_auto/LEXUS/LEXUS_NX/
/turbiny/107/*:/catalog_auto/SUBARU/
/turbiny/107/14083/*:/catalog_auto/SUBARU/SUBARU_LEVORG/
/turbiny/92/*:/catalog_auto/PORSCHE/
/turbiny/92/8263/*:/catalog_auto/PORSCHE/PORSCHE_PANAMERA/
/turbiny/92/38357/*:/catalog_auto/PORSCHE/PORSCHE_CAYENNE/
/turbiny/92/8741/*:/catalog_auto/PORSCHE/PORSCHE_CAYENNE/
/turbiny/2/*:/catalog_auto/ALFA_ROMEO/
/turbiny/2/36486/*:/catalog_auto/ALFA_ROMEO/ALFA_ROMEO_GIULIA/
/turbiny/2/4635/*:/catalog_auto/ALFA_ROMEO/ALFA_ROMEO_156/
/turbiny/2/37292/*:/catalog_auto/ALFA_ROMEO/ALFA_ROMEO_STELVIO/
/turbiny/29/*:/catalog_auto/DODGE/
/turbiny/29/7573/*:/catalog_auto/DODGE/DODGE_NITRO/
/turbiny/29/11117/*:/catalog_auto/DODGE/DODGE_RAM/
/turbiny/4473/*:/catalog_auto/GENESIS/
/turbiny/4473/37156/*:/catalog_auto/GENESIS/GENESIS_G90/
/turbiny/104/*:/catalog_auto/SEAT/
/turbiny/104/5431/*:/catalog_auto/SEAT/SEAT_LEON/
/turbiny/54/*:/catalog_auto/ISUZU/
/turbiny/99/*:/catalog_auto/SAAB/
/turbiny/20/*:/catalog_auto/CHRYSLER/
/turbiny/20/6443/*:/catalog_auto/CHRYSLER/
/turbiny/771/*:/catalog_auto/MASERATI/
/turbiny/771/1420/*:/catalog_auto/MASERATI/MASERATI_BITURBO/
/turbiny/139/*:/catalog_auto/DACIA/
/turbiny/139/8547/*:/catalog_auto/DACIA/DACIA_DUSTER/
/turbiny/815/*:/catalog_auto/BENTLEY/
/turbiny/776/*:/catalog_auto/FORD/
/turbiny/776/13370/*:/catalog_auto/FORD/
/turbiny/819/*:/catalog_auto/CADILLAC/
/turbiny/1518/*:/catalog_auto/MCLAREN/
/turbiny/64/*:/catalog_auto/LANCIA/
/turbiny/1506/*:/catalog_auto/HUMMER/
/turbiny/185/*:/catalog_auto/DAEWOO/
/turbiny/25/*:/catalog_auto/DAIHATSU/
/turbiny/95/*:/catalog_auto/ROVER/
TEXT;


$arrBdRedir = [];
$arrRedir = explode("
", strtolower($strMapRedir));
if (true)
    foreach ($arrRedir as $strR) {
        $p = explode(":", $strR);
        if (substr($p[0], -1) == '*') { //в шаблоне есть свобода (с)
            $searchUrl = str_replace('*', '', $p[0]);

            //текущий урл начинается с шаблона
            if (stripos($_SERVER['REQUEST_URI'], $searchUrl) === 0) {
                if (substr($p[0], -1) == '*') {
                    $param = str_replace($searchUrl, '', $_SERVER['REQUEST_URI']);//вытаскиваем свободу
                    $p[1] = str_replace('*', $param, $p[1]);//подставляем в конечный урл
                }

                header("HTTP/1.1 301 Moved Permanently");
                header("Location: " . $p[1]);
                exit();
            }
        } else if ($_SERVER['REQUEST_URI'] == $p[0]) {//текущий урл равен шаблону
            header("HTTP/1.1 301 Moved Permanently");
            header("Location: " . $p[1]);
            exit();
        }
    }


if (false) {
    ini_set('display_errors', 0);
    ini_set('error_reporting', 0);
    error_reporting(0);
} else {
    error_reporting(E_ALL ^ E_WARNING ^ E_DEPRECATED ^ E_NOTICE);
    ini_set('error_reporting', E_ALL ^ E_WARNING ^ E_DEPRECATED ^ E_NOTICE);

}

define('DATALIFEENGINE', true);
define('ROOT_DIR', dirname(__FILE__));
define('ENGINE_DIR', ROOT_DIR . '/engine');

require_once(ENGINE_DIR . '/classes/plugins.class.php');
require_once(DLEPlugins::Check(ROOT_DIR . '/engine/init.php'));

?>
