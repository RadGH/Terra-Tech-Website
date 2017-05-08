<?php
/*
Template Name: Test
*/

get_header();
?>

<?php if ( get_the_content() ) { ?>
	<div class="inside">
		<div class="post-content"><?php the_content(); ?></div>
	</div>
<?php } ?>
	
<style>
	.cell .inside-cell {
		text-align: center;
		color: #fff;
		font-size: 18px;
		font-weight: 700;
		padding: 20px 5px;
	}
	
	.cell:nth-child(1) .inside-cell { background: #f7412c; }
	.cell:nth-child(2) .inside-cell { background: #ec1562; }
	.cell:nth-child(3) .inside-cell { background: #9d1db2; }
	.cell:nth-child(4) .inside-cell { background: #6834bc; }
	.cell:nth-child(5) .inside-cell { background: #3f4db8; }
	.cell:nth-child(6) .inside-cell { background: #1294f6; }
	.cell:nth-child(7) .inside-cell { background: #00a7f6; }
	.cell:nth-child(8) .inside-cell { background: #00bcd7; }
	.cell:nth-child(9) .inside-cell { background: #009788; }
	.cell:nth-child(10) .inside-cell { background: #48b14c; }
	.cell:nth-child(11) .inside-cell { background: #89c541; }
	.cell:nth-child(12) .inside-cell { background: #cdde20; }
	
	.grid.custom-a .cell {
		float: left;
	}
	.grid.custom-a .cell:nth-child(4n+1) {
		width: 66%;
	}
	.grid.custom-a .cell:nth-child(4n+2) {
		width: 34%;
	}
	.grid.custom-a .cell:nth-child(4n+3) {
		width: 20%;
	}
	.grid.custom-a .cell:nth-child(4n+4) {
		width: 80%;
	}
</style>
	
<div class="inside">
	
	<h1>Grid Layouts</h1>
	
	<h2>Grid 2 column</h2>
	
	<div class="grid spacing grid-2col">
		<div class="cell"><div class="inside-cell">Cell 1</div></div>
		<div class="cell"><div class="inside-cell">Cell 2</div></div>
		<div class="cell"><div class="inside-cell">Cell 3</div></div>
		<div class="cell"><div class="inside-cell">Cell 4</div></div>
	</div>
	
	<p>No spacing</p>
	
	<div class="grid grid-2col">
		<div class="cell"><div class="inside-cell">Cell 1</div></div>
		<div class="cell"><div class="inside-cell">Cell 2</div></div>
		<div class="cell"><div class="inside-cell">Cell 3</div></div>
		<div class="cell"><div class="inside-cell">Cell 4</div></div>
	</div>
	
	<p>With 1 trailing cell</p>
	
	<div class="grid spacing grid-2col">
		<div class="cell"><div class="inside-cell">Cell 1</div></div>
	</div>
	
	<h2>Grid 3 column</h2>
	
	<div class="grid spacing grid-3col">
		<div class="cell"><div class="inside-cell">Cell 1</div></div>
		<div class="cell"><div class="inside-cell">Cell 2</div></div>
		<div class="cell"><div class="inside-cell">Cell 3</div></div>
		<div class="cell"><div class="inside-cell">Cell 4</div></div>
		<div class="cell"><div class="inside-cell">Cell 5</div></div>
		<div class="cell"><div class="inside-cell">Cell 6</div></div>
	</div>
	
	<p>No spacing</p>
	
	<div class="grid grid-3col">
		<div class="cell"><div class="inside-cell">Cell 1</div></div>
		<div class="cell"><div class="inside-cell">Cell 2</div></div>
		<div class="cell"><div class="inside-cell">Cell 3</div></div>
		<div class="cell"><div class="inside-cell">Cell 4</div></div>
		<div class="cell"><div class="inside-cell">Cell 5</div></div>
		<div class="cell"><div class="inside-cell">Cell 6</div></div>
	</div>
	
	<p>With 1 trailing cell</p>
	
	<div class="grid spacing grid-3col">
		<div class="cell"><div class="inside-cell">Cell 1</div></div>
	</div>
	
	<p>With 2 trailing cells</p>
	
	<div class="grid spacing grid-3col">
		<div class="cell"><div class="inside-cell">Cell 1</div></div>
		<div class="cell"><div class="inside-cell">Cell 2</div></div>
	</div>
	
	<h2>Grid 4 column</h2>
	
	<div class="grid spacing grid-4col">
		<div class="cell"><div class="inside-cell">Cell 1</div></div>
		<div class="cell"><div class="inside-cell">Cell 2</div></div>
		<div class="cell"><div class="inside-cell">Cell 3</div></div>
		<div class="cell"><div class="inside-cell">Cell 4</div></div>
		<div class="cell"><div class="inside-cell">Cell 5</div></div>
		<div class="cell"><div class="inside-cell">Cell 6</div></div>
		<div class="cell"><div class="inside-cell">Cell 7</div></div>
		<div class="cell"><div class="inside-cell">Cell 8</div></div>
	</div>
	
	<p>No spacing</p>
	
	<div class="grid grid-4col">
		<div class="cell"><div class="inside-cell">Cell 1</div></div>
		<div class="cell"><div class="inside-cell">Cell 2</div></div>
		<div class="cell"><div class="inside-cell">Cell 3</div></div>
		<div class="cell"><div class="inside-cell">Cell 4</div></div>
		<div class="cell"><div class="inside-cell">Cell 5</div></div>
		<div class="cell"><div class="inside-cell">Cell 6</div></div>
		<div class="cell"><div class="inside-cell">Cell 7</div></div>
		<div class="cell"><div class="inside-cell">Cell 8</div></div>
	</div>
	
	<p>With 1 trailing cell</p>
	
	<div class="grid spacing grid-4col">
		<div class="cell"><div class="inside-cell">Cell 1</div></div>
	</div>
	
	<p>With 2 trailing cells</p>
	
	<div class="grid spacing grid-4col">
		<div class="cell"><div class="inside-cell">Cell 1</div></div>
		<div class="cell"><div class="inside-cell">Cell 2</div></div>
	</div>
	
	<p>With 3 trailing cells</p>
	
	<div class="grid spacing grid-4col">
		<div class="cell"><div class="inside-cell">Cell 1</div></div>
		<div class="cell"><div class="inside-cell">Cell 2</div></div>
		<div class="cell"><div class="inside-cell">Cell 3</div></div>
	</div>
	
	<h2>Grid custom</h2>
	
	<div class="grid spacing custom-a">
		<div class="cell"><div class="inside-cell">Cell 1</div></div>
		<div class="cell"><div class="inside-cell">Cell 2</div></div>
		<div class="cell"><div class="inside-cell">Cell 3</div></div>
		<div class="cell"><div class="inside-cell">Cell 4</div></div>
	</div>
	
	<p>Custom grid CSS:</p>
	
	<pre>
.grid.custom-a .cell {
	float: left;
}
.grid.custom-a .cell:nth-child(4n+1) {
	width: 66%;
}
.grid.custom-a .cell:nth-child(4n+2) {
	width: 34%;
}
.grid.custom-a .cell:nth-child(4n+3) {
	width: 20%;
}
.grid.custom-a .cell:nth-child(4n+4) {
	width: 80%;
}
	</pre>
</div>

<div class="inside">
	<h1>Form Example</h1>
	
	<form action="#" method="POST">
		
		<table>
			<tr>
				<th>Text</th>
				<td><input type="text" name="" id=""></td>
			</tr>
			<tr>
				<th>Password</th>
				<td><input type="password" name="" id=""></td>
			</tr>
			<tr>
				<th>Email</th>
				<td><input type="email" name="" id=""></td>
			</tr>
			<tr>
				<th>Date</th>
				<td><input type="date" name="" id=""></td>
			</tr>
			<tr>
				<th>Tel</th>
				<td><input type="tel" name="" id=""></td>
			</tr>
			<tr>
				<th>Range</th>
				<td><input type="range" name="" id=""></td>
			</tr>
			<tr>
				<th>Text area</th>
				<td><textarea></textarea></td>
			</tr>
			<tr>
				<th>Checkbox</th>
				<td><label><input type="checkbox" name="" id=""> Subscribe to newsletter</label></td>
			</tr>
			<tr>
				<th>Radio Button</th>
				<td>
					<label><input type="radio" name="" id="" value="red"> Red</label><br>
					<label><input type="radio" name="" id="" value="green"> Green</label><br>
					<label><input type="radio" name="" id="" value="blue"> Blue</label>
				</td>
			</tr>
			<tr>
				<th>Dropdown</th>
				<td>
					<select name="" id="">
						<option value="">Red</option>
						<option value="">Green</option>
						<option value="">Blue</option>
					</select>
				</td>
			</tr>
			<tr>
				<th>File upload</th>
				<td><input type="file" name="" id=""></td>
			</tr>
			<tr>
				<th>Hidden input</th>
				<td><input type="hidden" name=""></td>
			</tr>
			<tr>
				<th>Submit button</th>
				<td><input type="submit" value="Submit"></td>
			</tr>
			<tr>
				<th>Input button</th>
				<td><input type="button" value="Click Here"></td>
			</tr>
			<tr>
				<th>HTML5 button</th>
				<td><button>Click here</button></td>
			</tr>
			<tr>
				<th>Link class button</th>
				<td><a class="button" href="#">Click here</a></td>
			</tr>
			<tr>
				<th></th>
				<td></td>
			</tr>
		</table>
		
	</form>
</div>
<?php
get_footer();