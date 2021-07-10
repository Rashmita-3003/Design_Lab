<?php 
					$i = 0;
					$arraylength= count($subject);
					
					while($i < $arraylength){
						
						?>
					<option value=<?php echo $subject[$i]?>><?php echo $subject[$i]?></option>
					<?php $i++;
					}
					?>