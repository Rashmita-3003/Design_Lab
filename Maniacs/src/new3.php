<?php 
				if(mysqli_num_rows($sql) > 0 && $getsub!=NULL){?>
					<table class="table table-dark table-striped">
						<thead>
						  <tr>
							<th>Name</th>
							<th>Email</th>
							<th>Subjects taught</th>
							<th>Highest Qualification</th>
						  </tr>
						</thead>
						<tbody>
					<?php	
					while($row = mysqli_fetch_array($sql)){?>
						
						  <tr>
							<td><input type="checkbox" class="form-check-input" name="pref[]" value=<?php echo $row['username']?>><?php echo $row['username'] ?></td>
							<td><?php echo $row['email'] ?></td>
							<td><?php echo $row['subjects'] ?></td>
							<td><?php echo $row['qualification'] ?></td>
						  </tr>
						
					<?php }?>
						</tbody>
					</table>
					<?php // Close result set
					//mysqli_free_result($sql);
				} else{?>
					<p>No records matching your prefernces found.</p>
				<?php	
				}
			?> 