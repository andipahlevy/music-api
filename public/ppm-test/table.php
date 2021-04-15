<!doctype html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Tes PPM Manajemen</title>
</head>
<body>
	<style>
	table.table {
		font-family: sans-serif;
		border: solid 1px #000;
		background: #0a0a0a;
	}
	td, th{
		padding:5px;
		border: solid 1px #000;
	}
	thead {
		background-color: #ccc;
	}
	tbody, tfoot{
		background: #fff;
	}
	</style>
	
	<table class="table">
		<thead>
			<tr>
				<th rowspan=2>NO</th>
				<th rowspan=2>NAMA PRODUK</th>
				<th rowspan=2>JENIS</th>
				<th colspan=2>HARGA</th>
			</tr>
			<tr>
				<th>Normal</th>
				<th>Promo</th>
			</tr>
		</thead>
		<tbody>
			<tr>
				<td>1</td>
				<td>LIFEBUOY</td>
				<td>SOAP</td>
				<td>2000</td>
				<td>1500</td>
			</tr>
			<tr>
				<td>2</td>
				<td>EMERON</td>
				<td>SHAMPOO</td>
				<td>3000</td>
				<td>2000</td>
			</tr>
			<tr>
				<td>3</td>
				<td>PEPSODENT</td>
				<td>TOOTHPASTE</td>
				<td>4000</td>
				<td>3500</td>
			</tr>
		</tbody>
		<tfoot>
			<tr>
				<td rowspan="2"></td>
				<td colspan="2">Total</td>
				<td>9000</td>
				<td>7000</td>
			</tr>
			<tr>
				<td colspan="3">Diskon</td>
				<td>2000</td>
			</tr>
		</tbody>
	</table>
</body>
</html>