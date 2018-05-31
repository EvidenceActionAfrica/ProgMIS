<?php  

/**
* 
*/
class csvmodel extends Database
{
    /**
    * Every model needs a database connection, passed to the model
    * @param object $db A PDO database connection
    */
    function __construct($db) {
        
        try {
            $this->db = $db;
        } catch (PDOException $e) {
            exit('Database connection could not be established.');
        }
    }


    /**
    * Description : This exports the data to excel
    *
    * @param string  string to display
    * @param mixed  variable to display with var_dump()
    * @param mixed ,... unlimited OPTIONAL number of additional variables to display with var_dump()
    * @return mixed ,int,string
    */
    
    public function export(array $sheet,array $header,$csv_name){
        // exit();
        date_default_timezone_set('Europe/London');

        if (PHP_SAPI == 'cli')
            die('This example should only be run from a Web Browser');

        // Create new PHPExcel object
        $objPHPExcel = new PHPExcel();

        // echo date('H:i:s') , " Load from Excel5 template" , EOL;
        // $objReader = PHPExcel_IOFactory::createReader('Excel5');

        // load the CSV template
        // $objPHPExcel = $objReader->load("public/excel-templates/county-return-template.xls");

        // Set document properties
        $objPHPExcel->getProperties()->setCreator("Evidence Action")
                                     ->setLastModifiedBy("Evidence Action")
                                     ->setTitle("Office 2007 XLSX Test Document")
                                     ->setSubject("Office 2007 XLSX Test Document")
                                     ->setDescription("County Returns.")
                                     ->setKeywords("office 2007 openxml php")
                                     ->setCategory("Test result file");

        // set the header
        $objPHPExcel->getActiveSheet()->fromArray($header, null, 'A1');
        $worksheet = $objPHPExcel->getActiveSheet();
        foreach($sheet as $row => $columns) {
            foreach($columns as $column => $data) {
                $worksheet->setCellValueByColumnAndRow($column, $row + 1, $data);
            }
        }

        // go through the data
        $objPHPExcel->getActiveSheet()->fromArray($sheet, null, 'A2');
        $worksheet = $objPHPExcel->getActiveSheet();
        foreach($sheet as $row => $columns) {
            foreach($columns as $column => $data) {
                $worksheet->setCellValueByColumnAndRow($column, $row + 1, $data);
            }
        }
        // echo "<pre>";var_dump($header);echo "</pre>";
        // echo "<pre>";var_dump($sheet);echo "</pre>";
        // exit();
        // Rename worksheet
        $objPHPExcel->getActiveSheet()->setTitle($csv_name);


        // Set active sheet index to the first sheet, so Excel opens this as the first sheet
        $objPHPExcel->setActiveSheetIndex(0);

        ob_clean();

        // Redirect output to a client’s web browser (Excel2007)
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="'.$csv_name.'".xlsx"');
        header('Cache-Control: max-age=0');

        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
        $objWriter->save('php://output');
        exit;



    } // end method


        /**
    * Description : Replace the underscore with spaces and mail(to, subject, message)ake the strings uppercase.
    *
    * @param string  $header
    * @return mixed  $data
    *
    */
    public function replace_upper($header){
        $data=array();
        $data[]="ID"; // this will the first title
        foreach ($header as $key => $value) {
            $string1=str_replace("_"," ",$value);
            $string2=strtoupper($string1);
            $data[]=$string2;
        }

        return $data;

    }


} // end class

?>