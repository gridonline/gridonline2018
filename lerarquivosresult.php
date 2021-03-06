<?php
//session_start();
require_once 'init.php';
//require 'check.php';

$PDO = db_connect(); 




// variável que define o diretório dos arquivos de resultado - desenvolvimento
//$dir = 'C:/Program Files (x86)/Steam/steamapps/common/assettocorsa/server/results'; 
// variável que define o diretório dos arquivos de resultado - producao
$dir = 'C:/Gridonline/acPackage/server/results'; 


// esse seria o "handler" do diretório
$dh = opendir($dir); 

// loop que busca todos os arquivos até que não encontre mais nada
while (false !== ($filename = readdir($dh))) { 

	if (substr($filename,-12) == "QUALIFY.json") { 
		// mostra o nome do arquivo e um link para ele - pode ser mudado para mostrar diretamente a imagem :)
		echo "<a href=\"$filename\">$filename</a><br>"; 

		$info = file_get_contents($dir."/".$filename);

		$json_output = json_decode($info);


						$sql= "SELECT idpistatorneio FROM pistatorneio INNER JOIN pista ON pista.idpista=pistatorneio.idpista WHERE pista.pista LIKE :trackname and pista.config LIKE :trackconfig";
						$stmt = $PDO->prepare($sql);
						$stmt->bindParam(':trackname', $json_output->TrackName, PDO::PARAM_STR);
						$stmt->bindParam(':trackconfig', $json_output->TrackConfig, PDO::PARAM_STR);
						$stmt->execute();
						$total = $stmt->rowCount();
						while ($row = $stmt->fetchObject()) {
  								 $torneio = $row->idpistatorneio;
								}
		      					                     

		$Result = $json_output->Result;

				foreach ( $Result as $r ) 
						{ 			
								

								if ($r->DriverName<>("")) {

								$sql ="SELECT idpiloto from piloto where guid=:guid";																			

					    		$sth = $PDO->prepare($sql);
			    		        $sth->bindParam("guid", $r->DriverGuid);
						        $sth->execute();
								$total = $sth->rowCount();

								if ($total<1) {
									$sql2 ="INSERT INTO piloto 
												(name, guid) 
											 VALUES 
											 	(:name, :guid)"; 			

						    		$sth2 = $PDO->prepare($sql2);
				    		        $sth2->bindParam(':name', $r->DriverName);
				    		        $sth2->bindParam(':guid', $r->DriverGuid);
							        $sth2->execute();

							        echo "Piloto inserido<br>";
									echo "<b>Nome:</b> ". $r->DriverName;
									echo "<b>GUID:</b> ".$r->DriverGuid;
									echo "<b>BestLap:</b> ".$r->BestLap;									
									echo "<br/>";

								}
								else {
									echo "Pilotos já se encontram na base de dados.<br>";
									echo "<b>Nome:</b> ". $r->DriverName;
									echo "<b>GUID:</b> ".$r->DriverGuid;	
									echo "<b>BestLap:</b> ".$r->BestLap;								
									echo "<br/>";									
									 }					
						        
								}


							 if ($r->BestLap<>"999999999") {

							 	

							 		$sqlbestlap ="SELECT idqualyresult,bestlap from qualyresult where guid=:guid";
							 		$sthbestlap = $PDO->prepare($sqlbestlap);
			     		        	$sthbestlap->bindParam(':guid', $r->DriverGuid);
						         	$sthbestlap->execute();
							 		$totalbestlap = $sthbestlap->rowCount();
							 		$resultbestlap = $sthbestlap->fetchAll( PDO::FETCH_ASSOC );

							 		
							 		 if ($totalbestlap==0) {
							 		 		$sqlpilotobestlap ="INSERT INTO qualyresult 
							 		 								(guid,bestlap,idpistatorneio) 
							 		 		 					VALUES 
							 		 		 						(:guid, :bestlap, :idpistatorneio)"; 

							 	     		$sthpilotobestlap = $PDO->prepare($sqlpilotobestlap);						    		        
						      		        $sthpilotobestlap->bindParam(':guid', $r->DriverGuid);
						      		        $sthpilotobestlap->bindParam(':bestlap', $r->BestLap);
						      		        $sthpilotobestlap->bindParam(':idpistatorneio', $torneio);
							 		        $sthpilotobestlap->execute();
							 		 } 
							 		else {
							 		
							 			foreach ($resultbestlap as $rbestlap ) {
							 				$bestlap=$rbestlap['bestlap'];																					
							 			}

							 				if ($r->BestLap<$bestlap) {

												$sqlpilotobestlap =

													 	"UPDATE qualyresult SET 
												             
												            bestlap = :bestlap 												            

												            WHERE idqualyresult =:idqualyresult";			

										    		$sthpilotobestlap = $PDO->prepare($sqlpilotobestlap);						    		      								    	        
								    		        $sthpilotobestlap->bindParam(':bestlap', $r->BestLap);								    		      
								    		        $sthpilotobestlap->bindParam(':idqualyresult', $rbestlap['idqualyresult']);								    		        
											        $sthpilotobestlap->execute();
											
										}

							 		 }							 		
							} 

						    
						}

	$origem = $dir."/".$filename;
	//Server de desenvolvimento
	//$destino = 'C:/Program Files (x86)/Steam/steamapps/common/assettocorsa/server/results/lidosqualify'."/".$filename;
	//Server de produção
	$destino = 'C:/Gridonline/acPackage/server/results/lidosqualify'."/".$filename;
	
	

	//aqui eu indico a pasta de destino mas eu n quero colocar o nome aqui. so a pasta e fazer a copia do arquivo. 
	
	if (copy($origem, $destino))
	{
	echo "Arquivo copiado com Sucesso.<br>";
	unlink($origem);
	}
	else
	{
	echo "Erro ao copiar arquivo.<br>";

	}						


	}

	if (substr($filename,-13) == "PRACTICE.json"){
		$origem2 = $dir."/".$filename;
		//server de desenvolvimento
		//$destino2 = 'C:/Program Files (x86)/Steam/steamapps/common/assettocorsa/server/results/lidospratice'."/".$filename;
		//server de produção
		$destino2 = 'C:/Gridonline/acPackage/server/results/lidospratice'."/".$filename;
		if (copy($origem2, $destino2))
		{	
		unlink($origem2);
		}
		else
		{
		echo "Erro ao copiar arquivo de PRACTICE.<br>";
		}	
	}


}

echo '<a href="panel.php">Voltar</a>';

?>

