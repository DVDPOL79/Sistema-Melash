<?php 

/*=============================================
Asignar sucursal a un administrador general
=============================================*/

if($_SESSION["admin"]->id_office_admin == 0 && isset($_GET["offices"])){

    $_SESSION["admin"]->id_office_admin = explode("_",$_GET["offices"])[0];
    $_SESSION["admin"]->title_office = explode("_",$_GET["offices"])[1];

}

if(isset($_GET["offices"]) && $_SESSION["admin"]->id_office_admin > 0){

    $_SESSION["admin"]->id_office_admin = explode("_",$_GET["offices"])[0];
    $_SESSION["admin"]->title_office = explode("_",$_GET["offices"])[1];
   
}

/*=============================================
Variable para actualizar el stock
=============================================*/

$updateStock = false;

/*=============================================
Abrir la página correspondiente del Dashboard
=============================================*/

if (!empty($routesArray[0])){

    $url = "relations?rel=modules,pages&type=module,page&linkTo=url_page&equalTo=".$routesArray[0];

    /*=============================================
   Activar la actualización del stock cuando estamos en pos o productos
    =============================================*/

    if($routesArray[0] == "pos" || $routesArray[0] == "productos"){

        $updateStock = true;

    }

    /*=============================================
    Confirmar Anular Factura Electrónica
    =============================================*/

    if($routesArray[0] == "facturacion" && 
        isset($_GET["idOrder"]) &&
        isset($_GET["document"]) &&
        isset($_GET["cude"]) &&
        !isset($_GET["confirmation"])){

        echo '<script>
        fncSweetAlert("confirm","¿Está seguro de anular la factura '.$_GET["document"].'?","").then(resp=>{
            if(resp){
                window.location = "'.$_SERVER["REQUEST_URI"].'&confirmation=ok";
            }
        })
        </script>';

    } 

    /*=============================================
    Procesar Anulación de Factura Electrónica
    =============================================*/

    if($routesArray[0] == "facturacion" && 
        isset($_GET["idOrder"]) &&
        isset($_GET["document"]) &&
        isset($_GET["cude"]) &&
        isset($_GET["confirmation"])){

        require_once "controllers/notes.controller.php";

        $createNote = NotesController::createNote($_GET["idOrder"],$_GET["document"],$_GET["cude"]);  
       
        if($createNote == "ok"){

            echo '<script>
                fncSweetAlert("success", "La nota crédito ha sido completada con éxito", "/facturacion");
            </script>';
        
        }else{

            echo '<script>
                fncSweetAlert("error", "'.$createNote.'", "/facturacion");
            </script>';
        }

    }

}else{

    $url = "relations?rel=modules,pages&type=module,page&linkTo=order_page&equalTo=1";

    if($_SESSION["admin"]->id_office_admin == 0 && !isset($_GET["offices"])){

        echo '<script>

        setTimeout(()=>{

            $("#myOffices").modal("show");

        },100);

        </script>';
    }

    $updateStock = true;
}

$method = "GET";
$fields = array();

$modules = CurlController::request($url,$method,$fields);

if($modules->status == 200){

    $modules = $modules->results;
   

}else{

    $modules = array();

}

/*=============================================
Actualizar el stock
=============================================*/

if($updateStock && $_SESSION["admin"]->id_office_admin > 0){

    /*=============================================
    Traer los productos de la sucursal
    =============================================*/
    $url = "products?linkTo=id_office_product&equalTo=".$_SESSION["admin"]->id_office_admin."&select=id_product";
    $method = "GET";
    $fields = array();

    $productsStock = CurlController::request($url,$method,$fields);
    
    if($productsStock->status == 200){

        $countStockProducts = 0;

        foreach ($productsStock->results as $key => $value) {

            /*=============================================
            Traer total de compras
            =============================================*/

            $url = "purchases?linkTo=id_product_purchase&equalTo=".$value->id_product."&select=qty_purchase";
            $purchases = CurlController::request($url,$method,$fields);
            
            $totalPurchaseProduct = 0;
         
            if($purchases->status == 200){

                foreach ($purchases->results as $index => $item) {

                    $totalPurchaseProduct += $item->qty_purchase;
                }
            }

            /*=============================================
            Traer total de ventas
            =============================================*/

            $url = "sales?linkTo=id_product_sale&equalTo=".$value->id_product."&select=qty_sale";
            $sales = CurlController::request($url,$method,$fields);

             $totalSaleProduct = 0;

            if($sales->status == 200){

              foreach ($sales->results as $index => $item) {

                $totalSaleProduct += $item->qty_sale;

              } 

            }

            /*=============================================
            Calcular compras menos ventas
            =============================================*/

            $arrayStock[$value->id_product] = ($totalPurchaseProduct - $totalSaleProduct);

            $countStockProducts++;

            if($countStockProducts == count($productsStock->results)){

                /*=============================================
                Actualizar stock en base de datos
                =============================================*/

                foreach ($arrayStock as $key => $value) {

                    $url = "products?id=".$key."&nameId=id_product&token=".$_SESSION["admin"]->token_admin."&table=admins&suffix=admin";
                    $method = "PUT";
                    $fields = array(
                        "stock_product" => $value
                    );

                    $fields = http_build_query($fields);
                    $updateStock = CurlController::request($url,$method,$fields);

                }
             
            }
           
        }

    }
   
}

/*=============================================
Buscar orden iniciada
=============================================*/

$url = "orders?linkTo=id_admin_order,status_order,id_office_order,date_created_order&equalTo=".$_SESSION["admin"]->id_admin.",Pendiente,".$_SESSION["admin"]->id_office_admin.",".date("Y-m-d");
$method = "GET";
$fields = array();

$order = CurlController::request($url,$method,$fields);

if($order->status == 200){

    $order = $order->results[0];
  
}else{

    $order = null;
}

?>
    
<div class="container-fluid py-3 p-lg-4">
          
    <div class="row">

        <?php if (!empty($modules)): ?>

            <?php foreach ($modules as $key => $value): $module = $value ?>

                <!--=========================================
                Cuando el módulo es un breadcrumb
                ===========================================-->

                <?php if ($module->type_module == "breadcrumbs"): ?>

                    <?php include "breadcrumbs/breadcrumbs.php" ?>
                    
                <?php endif ?>

                <!--=========================================
                Cuando el módulo es una métrica
                ===========================================-->

                <?php if ($module->type_module == "metrics"): ?>

                    <?php include "metrics/metrics.php" ?>
                    
                <?php endif ?>

                <!--=========================================
                Cuando el módulo es un gráfico
                ===========================================-->

                <?php if ($module->type_module == "graphics"): ?>

                    <?php include "graphics/graphics.php" ?>
                    
                <?php endif ?>

                <!--=========================================
                Cuando el módulo es una tabla
                ===========================================-->

                <?php if ($module->type_module == "tables"): ?>

                    <?php include "tables/tables.php" ?>
                    
                <?php endif ?>

                <!--=========================================
                Cuando el módulo es personalizado
                ===========================================-->

                <?php if ($module->type_module == "custom"): ?>

                    <?php include "custom/".str_replace(" ","_",$module->title_module)."/".str_replace(" ","_",$module->title_module).".php" ?>
                    
                <?php endif ?>
   
            <?php endforeach ?>
            
        <?php endif ?>

        <?php if ($_SESSION["admin"]->rol_admin == "superadmin"): ?>

                <div class="text-center <?php if (!empty($routesArray[1]) && $routesArray[1] == "manage"): ?> d-none  <?php endif ?>">
                
                    <button class="btn btn-default bg-white border rounded btn-sm ms-3 menu-text mt-1 py-2 px-3 myModule" idPage="<?php echo $page->results[0]->id_page ?>">Agregar Módulo</button>

                </div>
        
        <?php endif ?>

    </div>

</div>

<?php if (!isset($_SESSION["admin"]->phone_office)): ?>

    <?php include "views/modules/modals/offices.php"; ?>
    
<?php endif ?>

<script src="/views/assets/js/pos/pos.js"></script>
