<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;

class DownloadWillysImages extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'images:download';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Descargar imágenes desde una lista de URLs';

    /**
     * Lista de URLs de las imágenes a descargar.
     *
     * @var array
     */
    protected $imageUrls = [
        'https://willys-autoparts.s3.amazonaws.com/products/48b26f04-5748-457b-8c8f-fa71878ae8f3.JPG',
        'https://willys-autoparts.s3.amazonaws.com/products/87f9efd7-78fc-4654-97f0-d8aea40db8bf.JPG',
        'https://willys-autoparts.s3.amazonaws.com/products/2a015c3d-2831-4216-ba8c-9cd1be8f1d94.JPG',
        'https://willys-autoparts.s3.amazonaws.com/products/5ba22947-5301-4003-80d5-29bd238c53c9.JPG',
        'https://willys-autoparts.s3.amazonaws.com/products/0b9b7ec6-57f3-448c-9116-182d503e7550.JPG',
        'https://willys-autoparts.s3.amazonaws.com/products/19d3fa44-c03e-494e-8b49-4e8c423a177b.JPG',
        'https://willys-autoparts.s3.amazonaws.com/products/c1728e6a-9a49-4fb4-a4ae-cd886702bae3.JPG',
        'https://willys-autoparts.s3.amazonaws.com/products/2df65374-6203-4d0d-89e5-30b6726805ee.JPG',
        'https://willys-autoparts.s3.amazonaws.com/products/ba6842ee-6f07-4c80-b649-32af328cb22b.JPG',
        'https://willys-autoparts.s3.amazonaws.com/products/dcf3f8f1-6a9a-411e-907d-0b49b332edc6.JPG',
        'https://willys-autoparts.s3.amazonaws.com/products/8234a6f6-bba6-4d25-b35e-79ac9312b7b5.JPG',
        'https://willys-autoparts.s3.amazonaws.com/products/1ec10eec-adb2-4358-b332-c6e90ce9e8bd.JPG',
        'https://willys-autoparts.s3.amazonaws.com/products/541a51d3-279a-4d32-b98c-5d35de1889df.JPG',
        'https://willys-autoparts.s3.amazonaws.com/products/2c8e38f2-26fe-46a8-a50a-8af567f5014f.JPG',
        'https://willys-autoparts.s3.amazonaws.com/products/2440dec7-af17-4581-b380-43dc4f9c1034.JPG',
        'https://willys-autoparts.s3.amazonaws.com/products/a812747b-160d-49ac-966f-6951630d8792.JPG',
        'https://willys-autoparts.s3.amazonaws.com/products/275e6cd2-c1da-4f84-8d63-fa14dcce7a48.JPG',
        'https://willys-autoparts.s3.amazonaws.com/products/e0e6b976-dad1-4624-b6fa-e7fc80436509.JPG',
        'https://willys-autoparts.s3.amazonaws.com/products/2b326c9f-dc30-4b35-9219-88a7611272a2.JPG',
        'https://willys-autoparts.s3.amazonaws.com/products/17ce231e-0b56-4c39-9a0d-25b6cf9e8138.JPG',
        'https://willys-autoparts.s3.amazonaws.com/products/826f5353-4823-4b63-89b2-7a7e3bdcfa49.JPG',
        'https://willys-autoparts.s3.amazonaws.com/products/ae727c38-9acf-4813-ad23-722fa6c40792.JPG',
        'https://willys-autoparts.s3.amazonaws.com/products/33e665b5-2d9b-4e63-8e82-c5d86c07df62.JPG',
        'https://willys-autoparts.s3.amazonaws.com/products/e4227ff5-f25a-477d-a77e-5d7326e4fd10.JPG',
        'https://willys-autoparts.s3.amazonaws.com/products/ba9331e4-f5fa-4473-bd64-969075cffe98.JPG',
        'https://willys-autoparts.s3.amazonaws.com/products/d46722e3-10b1-45d1-bb08-011d3a924217.JPG',
        'https://willys-autoparts.s3.amazonaws.com/products/7db1541f-709a-4e8f-b6ba-942225b872b8.JPG',
        'https://willys-autoparts.s3.amazonaws.com/products/0e7cb48c-16dc-4d3e-a45f-a20dd5ee723f.JPG',
        'https://willys-autoparts.s3.amazonaws.com/products/625ecc56-d05a-4e4b-8a80-03d9e49f701c.JPG',
        'https://willys-autoparts.s3.amazonaws.com/products/f43342e9-57d9-433d-88ae-91cb5bf05ede.JPG',
        'https://willys-autoparts.s3.amazonaws.com/products/b4eb7ba0-fa1b-41b2-a722-ef61bc25a20b.JPG',
        'https://willys-autoparts.s3.amazonaws.com/products/231e787f-1b41-4c83-96c4-53383ef20700.JPG',
        'https://willys-autoparts.s3.amazonaws.com/products/685caf24-2f87-4f4e-95d2-4a4cba03d140.JPG',
        'https://willys-autoparts.s3.amazonaws.com/products/5d092a20-c4b1-4d4a-9534-14e0f56eb20d.JPG',
        'https://willys-autoparts.s3.amazonaws.com/products/2a1373d3-7b48-4803-8faf-5e680894b151.JPG',
        'https://willys-autoparts.s3.amazonaws.com/products/0ae6280f-7898-4b28-98a4-1267ce0d61d2.JPG',
        'https://willys-autoparts.s3.amazonaws.com/products/dec5534d-38e0-4e79-a501-8a5e6231294b.JPG',
        'https://willys-autoparts.s3.amazonaws.com/products/854a8ca7-a5c4-4e8d-86d6-f837cb50af69.JPG',
        'https://willys-autoparts.s3.amazonaws.com/products/24b8fe52-2a61-4da9-bc15-ed9a294c487c.JPG',
        'https://willys-autoparts.s3.amazonaws.com/products/9e59dcd3-95ed-4b60-92ce-3393d93a2a0c.JPG',
        'https://willys-autoparts.s3.amazonaws.com/products/54b94ad0-7c60-4a61-af2e-f9ccf339b2c7.JPG',
        'https://willys-autoparts.s3.amazonaws.com/products/cfaea5e5-6930-445f-813f-e750453fa8f4.JPG',
        'https://willys-autoparts.s3.amazonaws.com/products/2414b053-92be-41c8-9a94-c961a786ffe0.JPG',
        'https://willys-autoparts.s3.amazonaws.com/products/596c9107-dbca-440f-a1b5-48407d6c4550.JPG',
        'https://willys-autoparts.s3.amazonaws.com/products/9363a147-5f29-4267-b59e-a156f89ce2bd.JPG',
        'https://willys-autoparts.s3.amazonaws.com/products/49bc186c-3bc3-4068-9382-607f1897046f.JPG',
        'https://willys-autoparts.s3.amazonaws.com/products/4d147d64-e16d-4e69-8450-d16e6171495f.JPG',
        'https://willys-autoparts.s3.amazonaws.com/products/bc6bb8d7-b392-44fc-b997-9e0e89cae030.JPG',
        'https://willys-autoparts.s3.amazonaws.com/products/d6a573b9-e69b-491e-b406-8a347851472c.JPG',
        'https://willys-autoparts.s3.amazonaws.com/products/b9c1eed4-d4e3-4601-bc85-68aa074b37e0.JPG',
        'https://willys-autoparts.s3.amazonaws.com/products/a08c85bc-39b7-4e05-bffb-bc48c747975f.JPG',
        'https://willys-autoparts.s3.amazonaws.com/products/1f41cedc-6ab6-4444-9c4f-6fa5639761ff.JPG',
        'https://willys-autoparts.s3.amazonaws.com/products/d506c09f-32b4-401e-ab32-48c78962d580.JPG',
        'https://willys-autoparts.s3.amazonaws.com/products/80aea377-5e94-4818-9f4b-f430bbcbc1aa.JPG',
        'https://willys-autoparts.s3.amazonaws.com/products/7cd8b9da-53d8-489c-afb8-165f4e7fa0b9.JPG',
        'https://willys-autoparts.s3.amazonaws.com/products/a6653650-c5bc-4dc0-ab0d-348732cd70bf.JPG',
        'https://willys-autoparts.s3.amazonaws.com/products/093c93b6-c0f8-475e-9b96-a0bb2c522be1.JPG',
        'https://willys-autoparts.s3.amazonaws.com/products/5c6b60c4-90cf-4dea-9990-3b8499e27079.JPG',
        'https://willys-autoparts.s3.amazonaws.com/products/a2f7df7b-23c6-47a0-86e5-d30198510559.JPG',
        'https://willys-autoparts.s3.amazonaws.com/products/27890039-b6c2-4305-8266-8e8a8e290731.JPG',
        'https://willys-autoparts.s3.amazonaws.com/products/e9a22a91-1608-4598-a188-9f1fb67073ad.JPG',
        'https://willys-autoparts.s3.amazonaws.com/products/524315b8-8ad1-44f8-a073-c1a616ecdd2d.JPG',
        'https://willys-autoparts.s3.amazonaws.com/products/ce348e79-0c44-4546-ae98-022e804d3e54.JPG',
        'https://willys-autoparts.s3.amazonaws.com/products/44e08f31-fe88-4f36-b56d-abbf96667cfc.JPG',
        'https://willys-autoparts.s3.amazonaws.com/products/d84e184f-ab94-46df-a8c7-26ee5746cfa3.JPG',
        'https://willys-autoparts.s3.amazonaws.com/products/8e4d4c5d-437f-4ff0-bf06-ae6ac0175ced.JPG',
        'https://willys-autoparts.s3.amazonaws.com/products/1fbd7828-917e-4772-af4e-178825a54904.JPG',
        'https://willys-autoparts.s3.amazonaws.com/products/3185f635-e7ac-445d-9283-2cb042b40d27.JPG',
        'https://willys-autoparts.s3.amazonaws.com/products/a48acb92-d174-4d38-ab88-a55373ce49e6.JPG',
        'https://willys-autoparts.s3.amazonaws.com/products/6298aeca-3230-47ca-8b39-efa81d51f07d.JPG',
        'https://willys-autoparts.s3.amazonaws.com/products/bc7fe8a7-1c9e-4e4d-9d4b-aee65f3f65ed.JPG',
        'https://willys-autoparts.s3.amazonaws.com/products/e61b7b38-5b8f-4a14-a6a5-5b665584cce5.JPG',
        'https://willys-autoparts.s3.amazonaws.com/products/eff3ce3b-7ba4-45b2-a459-f6f6dbab0310.JPG',
        'https://willys-autoparts.s3.amazonaws.com/products/8167fe98-ce02-461b-ad25-15c2d1a4bfed.JPG',
        'https://willys-autoparts.s3.amazonaws.com/products/7ad02174-96ee-425c-9417-17830815a8d2.JPG',
        'https://willys-autoparts.s3.amazonaws.com/products/45f6c567-a413-4927-8ae0-3df8dcbcf870.JPG',
        'https://willys-autoparts.s3.amazonaws.com/products/022ac007-e103-478a-87b3-0670687aa30e.JPG',
        'https://willys-autoparts.s3.amazonaws.com/products/c2e9abd0-12e3-42a9-adaa-668a64e85c3b.JPG',
        'https://willys-autoparts.s3.amazonaws.com/products/d06fa72a-68ab-4367-b1ce-59cb58d872a4.JPG',
        'https://willys-autoparts.s3.amazonaws.com/products/d7761778-342f-42ca-9602-76464a2fab90.JPG',
        'https://willys-autoparts.s3.amazonaws.com/products/05f9753e-fad8-4758-a367-d9750d62970f.JPG',
        'https://willys-autoparts.s3.amazonaws.com/products/3b8bd938-e40c-4f16-b5fb-144a5b841c4b.JPG',
        'https://willys-autoparts.s3.amazonaws.com/products/7e2a8b44-9022-4ca3-b4be-04ad3d832dc4.JPG',
        'https://willys-autoparts.s3.amazonaws.com/products/1894a842-e3d0-4250-8206-f4459e984a43.JPG',
        'https://willys-autoparts.s3.amazonaws.com/products/649974fd-d68a-4fe8-ae72-84158c36b067.JPG',
        'https://willys-autoparts.s3.amazonaws.com/products/1ada0b58-3fbe-4370-bde8-406da8736f59.JPG',
        'https://willys-autoparts.s3.amazonaws.com/products/43b85d1e-6d17-45da-8cbf-bebf6b8ac36e.JPG',
        'https://willys-autoparts.s3.amazonaws.com/products/89050fcb-613b-4e22-ab56-be67eaeeaa56.JPG',
        'https://willys-autoparts.s3.amazonaws.com/products/444cb202-c7b2-46f6-bf5e-860a43cdc0d1.JPG',
        'https://willys-autoparts.s3.amazonaws.com/products/39ebfcf4-1348-4775-b0c6-c5d22b9f2b1d.JPG',
        'https://willys-autoparts.s3.amazonaws.com/products/14a1467b-a96b-40dd-8042-dd3f1f44feae.JPG',
        'https://willys-autoparts.s3.amazonaws.com/products/7533a0bf-d58b-474f-a627-60f0bfe864a6.JPG',
        'https://willys-autoparts.s3.amazonaws.com/products/f58b9f17-d1b3-4113-be5f-2646c96f8d43.JPG',
        'https://willys-autoparts.s3.amazonaws.com/products/29a60529-9df9-4b3a-b247-809ea84718cf.JPG',
        'https://willys-autoparts.s3.amazonaws.com/products/8dc4044e-dac2-45ff-aa96-1502ca9574d3.JPG',
        'https://willys-autoparts.s3.amazonaws.com/products/292ec76f-b522-40d2-a33b-10936ab9739a.JPG',
        'https://willys-autoparts.s3.amazonaws.com/products/b2e7cdbc-5785-48aa-b90b-f82ec810eafb.JPG',
        'https://willys-autoparts.s3.amazonaws.com/products/d51e78a6-8a0e-40fc-bb7a-2f9b1591efca.JPG',
        'https://willys-autoparts.s3.amazonaws.com/products/3a376de2-f3e4-4514-a4c2-6ef91e288d27.JPG',
        'https://willys-autoparts.s3.amazonaws.com/products/23df8502-79e6-477a-8348-302879aaa1e2.JPG',
        'https://willys-autoparts.s3.amazonaws.com/products/a36d4fb7-f7e7-4ded-8ba2-2c9c616e0c32.JPG',
        'https://willys-autoparts.s3.amazonaws.com/products/09670204-a8cf-4ef3-8520-44aa9cbe5300.JPG',
        'https://willys-autoparts.s3.amazonaws.com/products/eaeabe0d-cb07-4c56-9e05-0ce4fa0d8f58.JPG',
        'https://willys-autoparts.s3.amazonaws.com/products/e99ea2b9-359b-4263-9ce2-7e732daed342.JPG',
        'https://willys-autoparts.s3.amazonaws.com/products/a455fea5-7a52-4e7c-852f-91451190e5ad.JPG',
        'https://willys-autoparts.s3.amazonaws.com/products/6558e792-dab5-49d2-aafa-17a7167dc20f.JPG',
        'https://willys-autoparts.s3.amazonaws.com/products/4f5bc661-1a2f-40b0-b7b2-a892598c6118.JPG',
        'https://willys-autoparts.s3.amazonaws.com/products/6f8e8c93-77f1-4e10-ba09-ceff9590c453.JPG',
        'https://willys-autoparts.s3.amazonaws.com/products/aeb76233-26fb-4a80-ac65-901ab0e445af.JPG',
        'https://willys-autoparts.s3.amazonaws.com/products/33e08025-0c6f-49a1-a1dc-d070a313f5da.JPG',
        'https://willys-autoparts.s3.amazonaws.com/products/9fac3945-087e-429f-a26d-eab495026d64.JPG',
        'https://willys-autoparts.s3.amazonaws.com/products/92ead67c-6591-433b-9bc3-99424118ee54.JPG',
        'https://willys-autoparts.s3.amazonaws.com/products/b5d6307a-be0b-42ee-9285-3a668ad65127.JPG',
        'https://willys-autoparts.s3.amazonaws.com/products/91d800df-3409-428d-9074-40208b747ae5.JPG',
        'https://willys-autoparts.s3.amazonaws.com/products/c20ee684-6c2c-4291-95b4-6f7d7e4c22c8.JPG',
        'https://willys-autoparts.s3.amazonaws.com/products/0f6aab65-b4cf-481a-a5a4-1d8e603670b9.JPG',
        'https://willys-autoparts.s3.amazonaws.com/products/56fd4915-afa6-4e7a-83f1-d75e742b7c8b.JPG',
        'https://willys-autoparts.s3.amazonaws.com/products/cdbc8e4d-fef6-4a4c-bd25-fb9d151cfeb7.JPG',
        'https://willys-autoparts.s3.amazonaws.com/products/f8ccfec2-43f1-4b6e-a059-fc4ff0364d4e.JPG',
        'https://willys-autoparts.s3.amazonaws.com/products/4308d626-c20f-43b5-ac43-b0055570046a.JPG',
        'https://willys-autoparts.s3.amazonaws.com/products/98b434ba-bdfc-4162-9e25-dc06fd1e4f2e.JPG',
        'https://willys-autoparts.s3.amazonaws.com/products/fdf4f358-a95c-43c0-9c25-fa3e314030df.JPG',
        'https://willys-autoparts.s3.amazonaws.com/products/7f867b6c-eeca-47ae-94b6-9d71c26c82cb.JPG',
        'https://willys-autoparts.s3.amazonaws.com/products/d418344f-ffbb-444d-99f3-5a384ffd128b.JPG',
        'https://willys-autoparts.s3.amazonaws.com/products/b3b75640-e846-4fe2-8a06-8d35f250f1a0.JPG',
        'https://willys-autoparts.s3.amazonaws.com/products/776c1479-dc46-4d13-8a86-7880136d0d1c.JPG',
        'https://willys-autoparts.s3.amazonaws.com/products/86fc312c-2fff-40c7-bf80-f7782e056bf0.JPG',
        'https://willys-autoparts.s3.amazonaws.com/products/82195ddb-5b4d-4f97-888c-e79391bbfca8.JPG',
        'https://willys-autoparts.s3.amazonaws.com/products/09217a2e-6ed2-4b0b-a2af-7a886540ecfd.JPG',
        'https://willys-autoparts.s3.amazonaws.com/products/1e601e35-884d-42b2-a838-e953fd4a7165.JPG',
        'https://willys-autoparts.s3.amazonaws.com/products/0220bb43-0eee-4e30-b85a-548245eb6c86.JPG',
        'https://willys-autoparts.s3.amazonaws.com/products/264794a2-f249-4de8-ad4f-ae067a946032.JPG',
        'https://willys-autoparts.s3.amazonaws.com/products/36f3ab27-4d36-4ebf-b2ee-be8420fac8d4.JPG',
        'https://willys-autoparts.s3.amazonaws.com/products/1728d81c-626b-4d1c-b0f7-ad89274afd2f.JPG',
        'https://willys-autoparts.s3.amazonaws.com/products/f435da85-76ba-4b51-9349-963858d4d01f.JPG',
        'https://willys-autoparts.s3.amazonaws.com/products/86913404-4f03-4c32-bc3b-e6698d16cfcb.JPG',
        'https://willys-autoparts.s3.amazonaws.com/products/5ab9882d-c44a-4897-88ae-d927ad5d97db.JPG',
        'https://willys-autoparts.s3.amazonaws.com/products/c0ad5a55-2789-487d-ad04-6febde014f79.JPG',
        'https://willys-autoparts.s3.amazonaws.com/products/3ec998ee-41ec-4495-9ebc-4ea52dc0abb4.JPG',
        'https://willys-autoparts.s3.amazonaws.com/products/7eeee978-8dec-4927-8f8c-d5af76d2accd.JPG',
        'https://willys-autoparts.s3.amazonaws.com/products/a64797b8-b767-4d3a-a77e-713d11b03e4d.JPG',
        'https://willys-autoparts.s3.amazonaws.com/products/07b39956-2a74-43a9-bde8-2df8a91ed5fc.JPG',
        'https://willys-autoparts.s3.amazonaws.com/products/4b65f257-1e37-4f79-b672-f969bf5c3c57.JPG',
        'https://willys-autoparts.s3.amazonaws.com/products/4f7befdb-7d77-4507-8192-5e1984ffd845.JPG',
        'https://willys-autoparts.s3.amazonaws.com/products/a2ab83cb-fc95-4d9c-bc05-fbb75b5f10f5.JPG',
        'https://willys-autoparts.s3.amazonaws.com/products/d6eda29f-26b7-4e00-befc-0047ca14433b.JPG',
        'https://willys-autoparts.s3.amazonaws.com/products/cee59167-a9ef-4140-aa14-08503aff4b2b.JPG',
        'https://willys-autoparts.s3.amazonaws.com/products/833e7336-ac9d-4dc8-aee9-04a5771d7bd7.JPG',
        'https://willys-autoparts.s3.amazonaws.com/products/a58cae53-3d8d-4e6f-9df8-e330ec664987.JPG',
        'https://willys-autoparts.s3.amazonaws.com/products/adbe81af-e615-4bc6-9f3c-85e3ef6998c6.JPG',
        'https://willys-autoparts.s3.amazonaws.com/products/0e8f2d82-fbe4-4f32-bc94-ca999606e4c7.JPG',
        'https://willys-autoparts.s3.amazonaws.com/products/add97806-0bc2-4c9c-b1f4-11ae54486ee9.JPG',
        'https://willys-autoparts.s3.amazonaws.com/products/f32a8a05-d850-42e3-ba9e-aa3d5adc0eb3.JPG',
        'https://willys-autoparts.s3.amazonaws.com/products/798ef70b-5db2-42aa-81cc-815b04ced232.JPG',
        'https://willys-autoparts.s3.amazonaws.com/products/9d18e5e4-b4bd-467b-a1bc-de0b2f3cba14.JPG',
        'https://willys-autoparts.s3.amazonaws.com/products/ff964252-be0f-4f01-8cc3-97b731965889.JPG',
        'https://willys-autoparts.s3.amazonaws.com/products/1e109079-f356-4c3d-996b-2c4a50f0749f.JPG',
        'https://willys-autoparts.s3.amazonaws.com/products/730a4045-01a1-453a-9e1c-cdb9a8732e43.JPG',
        'https://willys-autoparts.s3.amazonaws.com/products/d907d717-6f6d-4d57-b598-c185a77e5d62.JPG',
        'https://willys-autoparts.s3.amazonaws.com/products/950fe918-9cc7-45ac-afb0-4436e6aad1a6.JPG',
        'https://willys-autoparts.s3.amazonaws.com/products/09fba026-7207-491b-88e2-643c7571d971.JPG',
        'https://willys-autoparts.s3.amazonaws.com/products/2e13b054-83ac-4a94-ad2c-921e645190c2.JPG',
        'https://willys-autoparts.s3.amazonaws.com/products/69241890-0470-41cb-ac1e-423c495309bc.JPG',
        'https://willys-autoparts.s3.amazonaws.com/products/b7109848-ce64-4d92-97a5-0e79a4a0267c.JPG',
        'https://willys-autoparts.s3.amazonaws.com/products/0071e288-1208-4078-b309-f4a46756c67f.JPG',
        'https://willys-autoparts.s3.amazonaws.com/products/73104569-9b19-4636-a1fd-ab21c186dd9f.JPG',
        'https://willys-autoparts.s3.amazonaws.com/products/81b30b8c-1532-4c5e-af80-1e9cd488ef8c.JPG',
        'https://willys-autoparts.s3.amazonaws.com/products/a2b5ffda-870f-4ba0-bad6-e79c146a92b3.JPG',
        'https://willys-autoparts.s3.amazonaws.com/products/2361adab-424a-491c-adba-8210df42f90f.JPG',
        'https://willys-autoparts.s3.amazonaws.com/products/86ddb237-9b8d-4bf9-8c40-255f532e86f6.JPG',
        'https://willys-autoparts.s3.amazonaws.com/products/2bbf2290-c49f-4eb4-8496-675e0adb1355.JPG',
        'https://willys-autoparts.s3.amazonaws.com/products/53280af0-447c-413d-94ac-9506f48c7817.JPG',
        'https://willys-autoparts.s3.amazonaws.com/products/55caf705-f6a4-426a-a419-32822ad4c445.JPG',
        'https://willys-autoparts.s3.amazonaws.com/products/40a163ed-2745-4d01-97c9-59d3ee6e8f36.JPG',
        'https://willys-autoparts.s3.amazonaws.com/products/47266b26-f7f3-44b6-b70b-96821925e346.JPG',
        'https://willys-autoparts.s3.amazonaws.com/products/682d44ef-949b-4d84-a7c6-dab6c0a0136e.JPG',
        'https://willys-autoparts.s3.amazonaws.com/products/16c1afa7-3796-412d-aeff-cdc7d8e3cc60.JPG',
        'https://willys-autoparts.s3.amazonaws.com/products/2b275214-5387-4ebd-9b11-f189a371707a.JPG',
        'https://willys-autoparts.s3.amazonaws.com/products/80cc1b21-5395-4fd8-be25-d239485aed92.JPG',
        'https://willys-autoparts.s3.amazonaws.com/products/c97cdc0e-15ff-43e6-99ef-21c01db8e1e4.JPG',
        'https://willys-autoparts.s3.amazonaws.com/products/21cf5296-21d8-4c69-9bd8-f302c51edc47.JPG',
        'https://willys-autoparts.s3.amazonaws.com/products/58f9d5ee-e4f3-494c-bc6a-9f8d0fedc51d.JPG',
        'https://willys-autoparts.s3.amazonaws.com/products/e9fde9e3-c37b-4826-b7d4-3fdcc492d187.JPG',
        'https://willys-autoparts.s3.amazonaws.com/products/ea0a382f-8431-4312-aeab-12e429a508c9.JPG',
        'https://willys-autoparts.s3.amazonaws.com/products/17129949-cab4-4169-8184-9ca2b879fdd3.JPG',
        'https://willys-autoparts.s3.amazonaws.com/products/5d21bf68-602a-41d3-ba5a-83492aba6b3c.JPG',
        'https://willys-autoparts.s3.amazonaws.com/products/1ef9ea15-b04f-46f4-b9be-40d2d6d7a31c.JPG',
        'https://willys-autoparts.s3.amazonaws.com/products/ed761097-f625-4c20-89c9-5aede5dc3a84.JPG',
        'https://willys-autoparts.s3.amazonaws.com/products/8ae005d5-02a9-458c-bb91-563758a0ec8c.JPG',
        'https://willys-autoparts.s3.amazonaws.com/products/f8f7c1b5-f526-49be-97fd-7e66b724283c.JPG',
        'https://willys-autoparts.s3.amazonaws.com/products/0b28c54d-a7f2-40dd-8d43-66ecf66b1969.JPG',
        'https://willys-autoparts.s3.amazonaws.com/products/889f5af0-be80-4392-9f56-ebcc235b7611.JPG',
        'https://willys-autoparts.s3.amazonaws.com/products/54c7a04f-ebd2-402f-8d0a-89c20f44fd2f.JPG',
        'https://willys-autoparts.s3.amazonaws.com/products/fc937a9e-3d78-4e0e-8d6e-d57f02c34ee4.JPG',
        'https://willys-autoparts.s3.amazonaws.com/products/669ccb6c-6b1a-457b-9261-deaff49306ae.JPG',
        'https://willys-autoparts.s3.amazonaws.com/products/5c5c4ac9-6920-49f8-a146-20a7120ea35f.JPG',
        'https://willys-autoparts.s3.amazonaws.com/products/1f108d92-b38b-415e-9b15-734ad6593b4f.JPG',
        'https://willys-autoparts.s3.amazonaws.com/products/ed5b6b1a-4951-4279-91c3-260da076dac8.JPG',
        'https://willys-autoparts.s3.amazonaws.com/products/fe08f1d1-b143-4a6b-9ff1-e6a4b1ecf1df.JPG',
        'https://willys-autoparts.s3.amazonaws.com/products/eff0ce87-4ead-4e03-9ae0-4e2256040627.JPG',
        'https://willys-autoparts.s3.amazonaws.com/products/0c6523c1-74b0-41e0-a212-43ad6057cbdb.JPG',
        'https://willys-autoparts.s3.amazonaws.com/products/b510fe1f-37a0-49fb-94af-f9bc8046a1ae.JPG',
        'https://willys-autoparts.s3.amazonaws.com/products/e7698741-5ba9-4c7d-bafb-3ab48a32e5cc.JPG',
        'https://willys-autoparts.s3.amazonaws.com/products/a5f7230e-25ad-4134-b347-f40ad1013603.JPG',
        'https://willys-autoparts.s3.amazonaws.com/products/fe765b5e-9178-4e8a-8c54-d360b3249c07.JPG',
        'https://willys-autoparts.s3.amazonaws.com/products/3d2f9828-186f-40a1-ad19-62b2bee2f986.JPG',
        'https://willys-autoparts.s3.amazonaws.com/products/781f1cff-3c3c-406a-ba9b-6a408e7b0255.JPG',
        'https://willys-autoparts.s3.amazonaws.com/products/2ed562a1-2ebd-4472-8ac2-b347efa328e0.JPG',
        'https://willys-autoparts.s3.amazonaws.com/products/f9d03a34-0689-4646-bcc7-af1cff115b75.JPG',
        'https://willys-autoparts.s3.amazonaws.com/products/c1ff6d97-afa9-48a7-8285-bafccd1d4e49.JPG',
        'https://willys-autoparts.s3.amazonaws.com/products/cc197351-1463-4de8-a476-89ee433c341e.JPG',
        'https://willys-autoparts.s3.amazonaws.com/products/0fa0d571-dc1a-4ebf-a0e4-884f793ee990.JPG',
        'https://willys-autoparts.s3.amazonaws.com/products/a9c2fc3f-56c1-406c-933c-08cbf40bfc13.JPG',
        'https://willys-autoparts.s3.amazonaws.com/products/ef2de14c-057f-409c-b44a-a493880b8278.JPG',
        'https://willys-autoparts.s3.amazonaws.com/products/05748972-ff72-4ad5-9305-3a738372958a.JPG',
        'https://willys-autoparts.s3.amazonaws.com/products/01a57a2f-aa18-48e4-9d68-a230933cf56e.JPG',
        'https://willys-autoparts.s3.amazonaws.com/products/1cf63f0e-22f7-4c2b-9410-987632fc2a21.JPG',
        'https://willys-autoparts.s3.amazonaws.com/products/36d9740a-eca9-4725-bdae-ae7d17561468.JPG',
        'https://willys-autoparts.s3.amazonaws.com/products/8d1a88ee-bba4-4b03-9575-f78276b4862a.JPG',
        'https://willys-autoparts.s3.amazonaws.com/products/ea2f2765-028a-4425-a843-873de08e4c44.JPG',
        'https://willys-autoparts.s3.amazonaws.com/products/5001408e-b59c-4d51-a32f-06a17b9f5cfe.JPG',
        'https://willys-autoparts.s3.amazonaws.com/products/36227bc0-3b04-4b76-87a1-0616d293d01c.JPG'
    ];

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $saveFolder = 'public/imagenes_descargadas'; // Carpeta para guardar las imágenes

        // Crear la carpeta si no existe
        if (!Storage::exists($saveFolder)) {
            Storage::makeDirectory($saveFolder);
        }

        foreach ($this->imageUrls as $url) {
            $this->downloadImage($url, $saveFolder);
        }

        $this->info('Todas las imágenes han sido descargadas.');
        return 0;
    }

    /**
     * Descargar una imagen desde una URL y guardarla en la carpeta especificada.
     *
     * @param string $url
     * @param string $folder
     * @return void
     */
    protected function downloadImage($url, $folder)
    {
        try {
            $response = Http::get($url);

            if ($response->successful()) {
                $imageName = basename($url);
                $imagePath = $folder . '/' . $imageName;

                Storage::put($imagePath, $response->body());

                $this->info("Imagen descargada: {$imagePath}");
            } else {
                $this->error("Error al descargar la imagen: {$url}");
            }
        } catch (\Exception $e) {
            $this->error("Excepción al descargar la imagen {$url}: " . $e->getMessage());
        }
    }
}
