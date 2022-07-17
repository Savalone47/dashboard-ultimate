<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

use App\Currency;

class CurrenciesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    	$data = array(
    		[ "id" => "1", "country" => "Albania", "currency" => "Leke", "code" => "ALL", "symbol" => "Lek", 
		"thousand_separator" => ",", "decimal_separator" => ".", "created_at" => NULL , "updated_at" => NULL ],
		[ "id" => "2", "country" => "America", "currency" => "Dollars", "code" => "USD", "symbol" => '$', 
		"thousand_separator" => ",", "decimal_separator" => ".", "created_at" => NULL , "updated_at" => NULL ],
		[ "id" => "3", "country" => "Afghanistan", "currency" => "Afghanis", "code" => "AF", "symbol" => "؋", 
		"thousand_separator" => ",", "decimal_separator" => ".", "created_at" => NULL , "updated_at" => NULL ],
		[ "id" => "4", "country" => "Argentina", "currency" => "Pesos", "code" => "ARS", "symbol" => '$', 
		"thousand_separator" => ",", "decimal_separator" => ".", "created_at" => NULL , "updated_at" => NULL ],
		[ "id" => "5", "country" => "Aruba", "currency" => "Guilders", "code" => "AWG", "symbol" => "ƒ", 
		"thousand_separator" => ",", "decimal_separator" => ".", "created_at" => NULL , "updated_at" => NULL ],
		[ "id" => "6", "country" => "Australia", "currency" => "Dollars", "code" => "AUD", "symbol" => '$', 
		"thousand_separator" => ",", "decimal_separator" => ".", "created_at" => NULL , "updated_at" => NULL ],
		[ "id" => "7", "country" => "Azerbaijan", "currency" => "New Manats", "code" => "AZ", "symbol" => "ман", 
		"thousand_separator" => ",", "decimal_separator" => ".", "created_at" => NULL , "updated_at" => NULL ],
		[ "id" => "8", "country" => "Bahamas", "currency" => "Dollars", "code" => "BSD", "symbol" => '$', 
		"thousand_separator" => ",", "decimal_separator" => ".", "created_at" => NULL , "updated_at" => NULL ],
		[ "id" => "9", "country" => "Barbados", "currency" => "Dollars", "code" => "BBD", "symbol" => '$', 
		"thousand_separator" => ",", "decimal_separator" => ".", "created_at" => NULL , "updated_at" => NULL ],
		[ "id" => "10", "country" => "Belarus", "currency" => "Rubles", "code" => "BYR", "symbol" => "p.", 
		"thousand_separator" => ",", "decimal_separator" => ".", "created_at" => NULL , "updated_at" => NULL ],
		[ "id" => "11", "country" => "Belgium", "currency" => "Euro", "code" => "EUR", "symbol" => "€", 
		"thousand_separator" => ",", "decimal_separator" => ".", "created_at" => NULL , "updated_at" => NULL ],
		[ "id" => "12", "country" => "Beliz", "currency" => "Dollars", "code" => "BZD", "symbol" => "BZ$", 
		"thousand_separator" => ",", "decimal_separator" => ".", "created_at" => NULL , "updated_at" => NULL ],
		[ "id" => "13", "country" => "Bermuda", "currency" => "Dollars", "code" => "BMD", "symbol" => '$', 
		"thousand_separator" => ",", "decimal_separator" => ".", "created_at" => NULL , "updated_at" => NULL ],
		[ "id" => "14", "country" => "Bolivia", "currency" => "Bolivianos", "code" => "BOB", "symbol" => '$b', 
		"thousand_separator" => ",", "decimal_separator" => ".", "created_at" => NULL , "updated_at" => NULL ],
		[ "id" => "15", "country" => "Bosnia and Herzegovina", "currency" => "Convertible Marka", "code" => "BAM", "symbol" => "KM", 
		"thousand_separator" => ",", "decimal_separator" => ".", "created_at" => NULL , "updated_at" => NULL ],
		[ "id" => "16", "country" => "Botswana", "currency" => "Pula's", "code" => "BWP", "symbol" => "P", 
		"thousand_separator" => ",", "decimal_separator" => ".", "created_at" => NULL , "updated_at" => NULL ],
		[ "id" => "17", "country" => "Bulgaria", "currency" => "Leva", "code" => "BG", "symbol" => "лв", 
		"thousand_separator" => ",", "decimal_separator" => ".", "created_at" => NULL , "updated_at" => NULL ],
		[ "id" => "18", "country" => "Brazil", "currency" => "Reais", "code" => "BRL", "symbol" => "R$", 
		"thousand_separator" => ",", "decimal_separator" => ".", "created_at" => NULL , "updated_at" => NULL ],
		[ "id" => "19", "country" => "Britain [United Kingdom]", "currency" => "Pounds", "code" => "GBP", "symbol" => "£", 
		"thousand_separator" => ",", "decimal_separator" => ".", "created_at" => NULL , "updated_at" => NULL ],
		[ "id" => "20", "country" => "Brunei Darussalam", "currency" => "Dollars", "code" => "BND", "symbol" => '$', 
		"thousand_separator" => ",", "decimal_separator" => ".", "created_at" => NULL , "updated_at" => NULL ],
		[ "id" => "21", "country" => "Cambodia", "currency" => "Riels", "code" => "KHR", "symbol" => "៛", 
		"thousand_separator" => ",", "decimal_separator" => ".", "created_at" => NULL , "updated_at" => NULL ],
		[ "id" => "22", "country" => "Canada", "currency" => "Dollars", "code" => "CAD", "symbol" => '$', 
		"thousand_separator" => ",", "decimal_separator" => ".", "created_at" => NULL , "updated_at" => NULL ],
		[ "id" => "23", "country" => "Cayman Islands", "currency" => "Dollars", "code" => "KYD", "symbol" => '$', 
		"thousand_separator" => ",", "decimal_separator" => ".", "created_at" => NULL , "updated_at" => NULL ],
		[ "id" => "24", "country" => "Chile", "currency" => "Pesos", "code" => "CLP", "symbol" => '$', 
		"thousand_separator" => ",", "decimal_separator" => ".", "created_at" => NULL , "updated_at" => NULL ],
		[ "id" => "25", "country" => "China", "currency" => "Yuan Renminbi", "code" => "CNY", "symbol" => "¥", 
		"thousand_separator" => ",", "decimal_separator" => ".", "created_at" => NULL , "updated_at" => NULL ],
		[ "id" => "26", "country" => "Colombia", "currency" => "Pesos", "code" => "COP", "symbol" => '$', 
		"thousand_separator" => ",", "decimal_separator" => ".", "created_at" => NULL , "updated_at" => NULL ],
		[ "id" => "27", "country" => "Costa Rica", "currency" => "Colón", "code" => "CRC", "symbol" => "₡", 
		"thousand_separator" => ",", "decimal_separator" => ".", "created_at" => NULL , "updated_at" => NULL ],
		[ "id" => "28", "country" => "Croatia", "currency" => "Kuna", "code" => "HRK", "symbol" => "kn", 
		"thousand_separator" => ",", "decimal_separator" => ".", "created_at" => NULL , "updated_at" => NULL ],
		[ "id" => "29", "country" => "Cuba", "currency" => "Pesos", "code" => "CUP", "symbol" => "₱", 
		"thousand_separator" => ",", "decimal_separator" => ".", "created_at" => NULL , "updated_at" => NULL ],
		[ "id" => "30", "country" => "Cyprus", "currency" => "Euro", "code" => "EUR", "symbol" => "€", 
		"thousand_separator" => ".", "decimal_separator" => ",", "created_at" => NULL , "updated_at" => NULL ],
		[ "id" => "31", "country" => "Czech Republic", "currency" => "Koruny", "code" => "CZK", "symbol" => "Kč", 
		"thousand_separator" => ",", "decimal_separator" => ".", "created_at" => NULL , "updated_at" => NULL ],
		[ "id" => "32", "country" => "Denmark", "currency" => "Kroner", "code" => "DKK", "symbol" => "kr", 
		"thousand_separator" => ",", "decimal_separator" => ".", "created_at" => NULL , "updated_at" => NULL ],
		[ "id" => "33", "country" => "Dominican Republic", "currency" => "Pesos", "code" => "DOP ", "symbol" => "RD$", 
		"thousand_separator" => ",", "decimal_separator" => ".", "created_at" => NULL , "updated_at" => NULL ],
		[ "id" => "34", "country" => "East Caribbean", "currency" => "Dollars", "code" => "XCD", "symbol" => '$', 
		"thousand_separator" => ",", "decimal_separator" => ".", "created_at" => NULL , "updated_at" => NULL ],
		[ "id" => "35", "country" => "Egypt", "currency" => "Pounds", "code" => "EGP", "symbol" => "£", 
		"thousand_separator" => ",", "decimal_separator" => ".", "created_at" => NULL , "updated_at" => NULL ],
		[ "id" => "36", "country" => "El Salvador", "currency" => "Colones", "code" => "SVC", "symbol" => '$', 
		"thousand_separator" => ",", "decimal_separator" => ".", "created_at" => NULL , "updated_at" => NULL ],
		[ "id" => "37", "country" => "England [United Kingdom]", "currency" => "Pounds", "code" => "GBP", "symbol" => "£", 
		"thousand_separator" => ",", "decimal_separator" => ".", "created_at" => NULL , "updated_at" => NULL ],
		[ "id" => "38", "country" => "Euro", "currency" => "Euro", "code" => "EUR", "symbol" => "€", 
		"thousand_separator" => ".", "decimal_separator" => ",", "created_at" => NULL , "updated_at" => NULL ],
		[ "id" => "39", "country" => "Falkland Islands", "currency" => "Pounds", "code" => "FKP", "symbol" => "£", 
		"thousand_separator" => ",", "decimal_separator" => ".", "created_at" => NULL , "updated_at" => NULL ],
		[ "id" => "40", "country" => "Fiji", "currency" => "Dollars", "code" => "FJD", "symbol" => '$', 
		"thousand_separator" => ",", "decimal_separator" => ".", "created_at" => NULL , "updated_at" => NULL ],
		[ "id" => "41", "country" => "France", "currency" => "Euro", "code" => "EUR", "symbol" => "€", 
		"thousand_separator" => ".", "decimal_separator" => ",", "created_at" => NULL , "updated_at" => NULL ],
		[ "id" => "42", "country" => "Ghana", "currency" => "Cedis", "code" => "GHC", "symbol" => "¢", 
		"thousand_separator" => ",", "decimal_separator" => ".", "created_at" => NULL , "updated_at" => NULL ],
		[ "id" => "43", "country" => "Gibraltar", "currency" => "Pounds", "code" => "GIP", "symbol" => "£", 
		"thousand_separator" => ",", "decimal_separator" => ".", "created_at" => NULL , "updated_at" => NULL ],
		[ "id" => "44", "country" => "Greece", "currency" => "Euro", "code" => "EUR", "symbol" => "€", 
		"thousand_separator" => ".", "decimal_separator" => ",", "created_at" => NULL , "updated_at" => NULL ],
		[ "id" => "45", "country" => "Guatemala", "currency" => "Quetzales", "code" => "GTQ", "symbol" => "Q", 
		"thousand_separator" => ",", "decimal_separator" => ".", "created_at" => NULL , "updated_at" => NULL ],
		[ "id" => "46", "country" => "Guernsey", "currency" => "Pounds", "code" => "GGP", "symbol" => "£", 
		"thousand_separator" => ",", "decimal_separator" => ".", "created_at" => NULL , "updated_at" => NULL ],
		[ "id" => "47", "country" => "Guyana", "currency" => "Dollars", "code" => "GYD", "symbol" => '$', 
		"thousand_separator" => ",", "decimal_separator" => ".", "created_at" => NULL , "updated_at" => NULL ],
		[ "id" => "48", "country" => "Holland [Netherlands]", "currency" => "Euro", "code" => "EUR", "symbol" => "€", 
		"thousand_separator" => ".", "decimal_separator" => ",", "created_at" => NULL , "updated_at" => NULL ],
		[ "id" => "49", "country" => "Honduras", "currency" => "Lempiras", "code" => "HNL", "symbol" => "L", 
		"thousand_separator" => ",", "decimal_separator" => ".", "created_at" => NULL , "updated_at" => NULL ],
		[ "id" => "50", "country" => "Hong Kong", "currency" => "Dollars", "code" => "HKD", "symbol" => '$', 
		"thousand_separator" => ",", "decimal_separator" => ".", "created_at" => NULL , "updated_at" => NULL ],
		[ "id" => "51", "country" => "Hungary", "currency" => "Forint", "code" => "HUF", "symbol" => "Ft", 
		"thousand_separator" => ",", "decimal_separator" => ".", "created_at" => NULL , "updated_at" => NULL ],
		[ "id" => "52", "country" => "Iceland", "currency" => "Kronur", "code" => "ISK", "symbol" => "kr", 
		"thousand_separator" => ",", "decimal_separator" => ".", "created_at" => NULL , "updated_at" => NULL ],
		[ "id" => "53", "country" => "India", "currency" => "Rupees", "code" => "INR", "symbol" => "₹", 
		"thousand_separator" => ",", "decimal_separator" => ".", "created_at" => NULL , "updated_at" => NULL ],
		[ "id" => "54", "country" => "Indonesia", "currency" => "Rupiahs", "code" => "IDR", "symbol" => "Rp", 
		"thousand_separator" => ",", "decimal_separator" => ".", "created_at" => NULL , "updated_at" => NULL ],
		[ "id" => "55", "country" => "Iran", "currency" => "Rials", "code" => "IRR", "symbol" => "﷼", 
		"thousand_separator" => ",", "decimal_separator" => ".", "created_at" => NULL , "updated_at" => NULL ],
		[ "id" => "56", "country" => "Ireland", "currency" => "Euro", "code" => "EUR", "symbol" => "€", 
		"thousand_separator" => ".", "decimal_separator" => ",", "created_at" => NULL , "updated_at" => NULL ],
		[ "id" => "57", "country" => "Isle of Man", "currency" => "Pounds", "code" => "IMP", "symbol" => "£", 
		"thousand_separator" => ",", "decimal_separator" => ".", "created_at" => NULL , "updated_at" => NULL ],
		[ "id" => "58", "country" => "Israel", "currency" => "New Shekels", "code" => "ILS", "symbol" => "₪", 
		"thousand_separator" => ",", "decimal_separator" => ".", "created_at" => NULL , "updated_at" => NULL ],
		[ "id" => "59", "country" => "Italy", "currency" => "Euro", "code" => "EUR", "symbol" => "€", 
		"thousand_separator" => ".", "decimal_separator" => ",", "created_at" => NULL , "updated_at" => NULL ],
		[ "id" => "60", "country" => "Jamaica", "currency" => "Dollars", "code" => "JMD", "symbol" => "J$", 
		"thousand_separator" => ",", "decimal_separator" => ".", "created_at" => NULL , "updated_at" => NULL ],
		[ "id" => "61", "country" => "Japan", "currency" => "Yen", "code" => "JPY", "symbol" => "¥", 
		"thousand_separator" => ",", "decimal_separator" => ".", "created_at" => NULL , "updated_at" => NULL ],
		[ "id" => "62", "country" => "Jersey", "currency" => "Pounds", "code" => "JEP", "symbol" => "£", 
		"thousand_separator" => ",", "decimal_separator" => ".", "created_at" => NULL , "updated_at" => NULL ],
		[ "id" => "63", "country" => "Kazakhstan", "currency" => "Tenge", "code" => "KZT", "symbol" => "лв", 
		"thousand_separator" => ",", "decimal_separator" => ".", "created_at" => NULL , "updated_at" => NULL ],
		[ "id" => "64", "country" => "Korea [North]", "currency" => "Won", "code" => "KPW", "symbol" => "₩", 
		"thousand_separator" => ",", "decimal_separator" => ".", "created_at" => NULL , "updated_at" => NULL ],
		[ "id" => "65", "country" => "Korea [South]", "currency" => "Won", "code" => "KRW", "symbol" => "₩", 
		"thousand_separator" => ",", "decimal_separator" => ".", "created_at" => NULL , "updated_at" => NULL ],
		[ "id" => "66", "country" => "Kyrgyzstan", "currency" => "Soms", "code" => "KGS", "symbol" => "лв", 
		"thousand_separator" => ",", "decimal_separator" => ".", "created_at" => NULL , "updated_at" => NULL ],
		[ "id" => "67", "country" => "Laos", "currency" => "Kips", "code" => "LAK", "symbol" => "₭", 
		"thousand_separator" => ",", "decimal_separator" => ".", "created_at" => NULL , "updated_at" => NULL ],
		[ "id" => "68", "country" => "Latvia", "currency" => "Lati", "code" => "LVL", "symbol" => "Ls", 
		"thousand_separator" => ",", "decimal_separator" => ".", "created_at" => NULL , "updated_at" => NULL ],
		[ "id" => "69", "country" => "Lebanon", "currency" => "Pounds", "code" => "LBP", "symbol" => "£", 
		"thousand_separator" => ",", "decimal_separator" => ".", "created_at" => NULL , "updated_at" => NULL ],
		[ "id" => "70", "country" => "Liberia", "currency" => "Dollars", "code" => "LRD", "symbol" => '$', 
		"thousand_separator" => ",", "decimal_separator" => ".", "created_at" => NULL , "updated_at" => NULL ],
		[ "id" => "71", "country" => "Liechtenstein", "currency" => "Switzerland Francs", "code" => "CHF", "symbol" => "CHF", 
		"thousand_separator" => ",", "decimal_separator" => ".", "created_at" => NULL , "updated_at" => NULL ],
		[ "id" => "72", "country" => "Lithuania", "currency" => "Litai", "code" => "LTL", "symbol" => "Lt", 
		"thousand_separator" => ",", "decimal_separator" => ".", "created_at" => NULL , "updated_at" => NULL ],
		[ "id" => "73", "country" => "Luxembourg", "currency" => "Euro", "code" => "EUR", "symbol" => "€", 
		"thousand_separator" => ".", "decimal_separator" => ",", "created_at" => NULL , "updated_at" => NULL ],
		[ "id" => "74", "country" => "Macedonia", "currency" => "Denars", "code" => "MKD", "symbol" => "ден", 
		"thousand_separator" => ",", "decimal_separator" => ".", "created_at" => NULL , "updated_at" => NULL ],
		[ "id" => "75", "country" => "Malaysia", "currency" => "Ringgits", "code" => "MYR", "symbol" => "RM", 
		"thousand_separator" => ",", "decimal_separator" => ".", "created_at" => NULL , "updated_at" => NULL ],
		[ "id" => "76", "country" => "Malta", "currency" => "Euro", "code" => "EUR", "symbol" => "€", 
		"thousand_separator" => ".", "decimal_separator" => ",", "created_at" => NULL , "updated_at" => NULL ],
		[ "id" => "77", "country" => "Mauritius", "currency" => "Rupees", "code" => "MUR", "symbol" => "₨", 
		"thousand_separator" => ",", "decimal_separator" => ".", "created_at" => NULL , "updated_at" => NULL ],
		[ "id" => "78", "country" => "Mexico", "currency" => "Pesos", "code" => "MX", "symbol" => '$', 
		"thousand_separator" => ",", "decimal_separator" => ".", "created_at" => NULL , "updated_at" => NULL ],
		[ "id" => "79", "country" => "Mongolia", "currency" => "Tugriks", "code" => "MNT", "symbol" => "₮", 
		"thousand_separator" => ",", "decimal_separator" => ".", "created_at" => NULL , "updated_at" => NULL ],
		[ "id" => "80", "country" => "Mozambique", "currency" => "Meticais", "code" => "MZ", "symbol" => "MT", 
		"thousand_separator" => ",", "decimal_separator" => ".", "created_at" => NULL , "updated_at" => NULL ],
		[ "id" => "81", "country" => "Namibia", "currency" => "Dollars", "code" => "NAD", "symbol" => '$', 
		"thousand_separator" => ",", "decimal_separator" => ".", "created_at" => NULL , "updated_at" => NULL ],
		[ "id" => "82", "country" => "Nepal", "currency" => "Rupees", "code" => "NPR", "symbol" => "₨", 
		"thousand_separator" => ",", "decimal_separator" => ".", "created_at" => NULL , "updated_at" => NULL ],
		[ "id" => "83", "country" => "Netherlands Antilles", "currency" => "Guilders", "code" => "ANG", "symbol" => "ƒ", 
		"thousand_separator" => ",", "decimal_separator" => ".", "created_at" => NULL , "updated_at" => NULL ],
		[ "id" => "84", "country" => "Netherlands", "currency" => "Euro", "code" => "EUR", "symbol" => "€", 
		"thousand_separator" => ".", "decimal_separator" => ",", "created_at" => NULL , "updated_at" => NULL ],
		[ "id" => "85", "country" => "New Zealand", "currency" => "Dollars", "code" => "NZD", "symbol" => '$', 
		"thousand_separator" => ",", "decimal_separator" => ".", "created_at" => NULL , "updated_at" => NULL ],
		[ "id" => "86", "country" => "Nicaragua", "currency" => "Cordobas", "code" => "NIO", "symbol" => "C$", 
		"thousand_separator" => ",", "decimal_separator" => ".", "created_at" => NULL , "updated_at" => NULL ],
		[ "id" => "87", "country" => "Nigeria", "currency" => "Nairas", "code" => "NG", "symbol" => "₦", 
		"thousand_separator" => ",", "decimal_separator" => ".", "created_at" => NULL , "updated_at" => NULL ],
		[ "id" => "88", "country" => "North Korea", "currency" => "Won", "code" => "KPW", "symbol" => "₩", 
		"thousand_separator" => ",", "decimal_separator" => ".", "created_at" => NULL , "updated_at" => NULL ],
		[ "id" => "89", "country" => "Norway", "currency" => "Krone", "code" => "NOK", "symbol" => "kr", 
		"thousand_separator" => ",", "decimal_separator" => ".", "created_at" => NULL , "updated_at" => NULL ],
		[ "id" => "90", "country" => "Oman", "currency" => "Rials", "code" => "OMR", "symbol" => "﷼", 
		"thousand_separator" => ",", "decimal_separator" => ".", "created_at" => NULL , "updated_at" => NULL ],
		[ "id" => "91", "country" => "Pakistan", "currency" => "Rupees", "code" => "PKR", "symbol" => "₨", 
		"thousand_separator" => ",", "decimal_separator" => ".", "created_at" => NULL , "updated_at" => NULL ],
		[ "id" => "92", "country" => "Panama", "currency" => "Balboa", "code" => "PAB", "symbol" => "B/.", 
		"thousand_separator" => ",", "decimal_separator" => ".", "created_at" => NULL , "updated_at" => NULL ],
		[ "id" => "93", "country" => "Paraguay", "currency" => "Guarani", "code" => "PYG", "symbol" => "Gs", 
		"thousand_separator" => ",", "decimal_separator" => ".", "created_at" => NULL , "updated_at" => NULL ],
		[ "id" => "94", "country" => "Peru", "currency" => "Nuevos Soles", "code" => "PE", "symbol" => "S/.", 
		"thousand_separator" => ",", "decimal_separator" => ".", "created_at" => NULL , "updated_at" => NULL ],
		[ "id" => "95", "country" => "Philippines", "currency" => "Pesos", "code" => "PHP", "symbol" => "Php", 
		"thousand_separator" => ",", "decimal_separator" => ".", "created_at" => NULL , "updated_at" => NULL ],
		[ "id" => "96", "country" => "Poland", "currency" => "Zlotych", "code" => "PL", "symbol" => "zł", 
		"thousand_separator" => ",", "decimal_separator" => ".", "created_at" => NULL , "updated_at" => NULL ],
		[ "id" => "97", "country" => "Qatar", "currency" => "Rials", "code" => "QAR", "symbol" => "﷼", 
		"thousand_separator" => ",", "decimal_separator" => ".", "created_at" => NULL , "updated_at" => NULL ],
		[ "id" => "98", "country" => "Romania", "currency" => "New Lei", "code" => "RO", "symbol" => "lei", 
		"thousand_separator" => ",", "decimal_separator" => ".", "created_at" => NULL , "updated_at" => NULL ],
		[ "id" => "99", "country" => "Russia", "currency" => "Rubles", "code" => "RUB", "symbol" => "руб", 
		"thousand_separator" => ",", "decimal_separator" => ".", "created_at" => NULL , "updated_at" => NULL ],
		[ "id" => "100", "country" => "Saint Helena", "currency" => "Pounds", "code" => "SHP", "symbol" => "£", 
		"thousand_separator" => ",", "decimal_separator" => ".", "created_at" => NULL , "updated_at" => NULL ],
		[ "id" => "101", "country" => "Saudi Arabia", "currency" => "Riyals", "code" => "SAR", "symbol" => "﷼", 
		"thousand_separator" => ",", "decimal_separator" => ".", "created_at" => NULL , "updated_at" => NULL ],
		[ "id" => "102", "country" => "Serbia", "currency" => "Dinars", "code" => "RSD", "symbol" => "Дин.", 
		"thousand_separator" => ",", "decimal_separator" => ".", "created_at" => NULL , "updated_at" => NULL ],
		[ "id" => "103", "country" => "Seychelles", "currency" => "Rupees", "code" => "SCR", "symbol" => "₨", 
		"thousand_separator" => ",", "decimal_separator" => ".", "created_at" => NULL , "updated_at" => NULL ],
		[ "id" => "104", "country" => "Singapore", "currency" => "Dollars", "code" => "SGD", "symbol" => '$', 
		"thousand_separator" => ",", "decimal_separator" => ".", "created_at" => NULL , "updated_at" => NULL ],
		[ "id" => "105", "country" => "Slovenia", "currency" => "Euro", "code" => "EUR", "symbol" => "€", 
		"thousand_separator" => ".", "decimal_separator" => ",", "created_at" => NULL , "updated_at" => NULL ],
		[ "id" => "106", "country" => "Solomon Islands", "currency" => "Dollars", "code" => "SBD", "symbol" => '$', 
		"thousand_separator" => ",", "decimal_separator" => ".", "created_at" => NULL , "updated_at" => NULL ],
		[ "id" => "107", "country" => "Somalia", "currency" => "Shillings", "code" => "SOS", "symbol" => "S", 
		"thousand_separator" => ",", "decimal_separator" => ".", "created_at" => NULL , "updated_at" => NULL ],
		[ "id" => "108", "country" => "South Africa", "currency" => "Rand", "code" => "ZAR", "symbol" => "R", 
		"thousand_separator" => ",", "decimal_separator" => ".", "created_at" => NULL , "updated_at" => NULL ],
		[ "id" => "109", "country" => "South Korea", "currency" => "Won", "code" => "KRW", "symbol" => "₩", 
		"thousand_separator" => ",", "decimal_separator" => ".", "created_at" => NULL , "updated_at" => NULL ],
		[ "id" => "110", "country" => "Spain", "currency" => "Euro", "code" => "EUR", "symbol" => "€", 
		"thousand_separator" => ".", "decimal_separator" => ",", "created_at" => NULL , "updated_at" => NULL ],
		[ "id" => "111", "country" => "Sri Lanka", "currency" => "Rupees", "code" => "LKR", "symbol" => "₨", 
		"thousand_separator" => ",", "decimal_separator" => ".", "created_at" => NULL , "updated_at" => NULL ],
		[ "id" => "112", "country" => "Sweden", "currency" => "Kronor", "code" => "SEK", "symbol" => "kr", 
		"thousand_separator" => ",", "decimal_separator" => ".", "created_at" => NULL , "updated_at" => NULL ],
		[ "id" => "113", "country" => "Switzerland", "currency" => "Francs", "code" => "CHF", "symbol" => "CHF", 
		"thousand_separator" => ",", "decimal_separator" => ".", "created_at" => NULL , "updated_at" => NULL ],
		[ "id" => "114", "country" => "Suriname", "currency" => "Dollars", "code" => "SRD", "symbol" => '$', 
		"thousand_separator" => ",", "decimal_separator" => ".", "created_at" => NULL , "updated_at" => NULL ],
		[ "id" => "115", "country" => "Syria", "currency" => "Pounds", "code" => "SYP", "symbol" => "£", 
		"thousand_separator" => ",", "decimal_separator" => ".", "created_at" => NULL , "updated_at" => NULL ],
		[ "id" => "116", "country" => "Taiwan", "currency" => "New Dollars", "code" => "TWD", "symbol" => "NT$", 
		"thousand_separator" => ",", "decimal_separator" => ".", "created_at" => NULL , "updated_at" => NULL ],
		[ "id" => "117", "country" => "Thailand", "currency" => "Baht", "code" => "THB", "symbol" => "฿", 
		"thousand_separator" => ",", "decimal_separator" => ".", "created_at" => NULL , "updated_at" => NULL ],
		[ "id" => "118", "country" => "Trinidad and Tobago", "currency" => "Dollars", "code" => "TTD", "symbol" => "TT$", 
		"thousand_separator" => ",", "decimal_separator" => ".", "created_at" => NULL , "updated_at" => NULL ],
		[ "id" => "119", "country" => "Turkey", "currency" => "Lira", "code" => "TRY", "symbol" => "TL", 
		"thousand_separator" => ",", "decimal_separator" => ".", "created_at" => NULL , "updated_at" => NULL ],
		[ "id" => "120", "country" => "Turkey", "currency" => "Liras", "code" => "TRL", "symbol" => "£", 
		"thousand_separator" => ",", "decimal_separator" => ".", "created_at" => NULL , "updated_at" => NULL ],
		[ "id" => "121", "country" => "Tuvalu", "currency" => "Dollars", "code" => "TVD", "symbol" => '$', 
		"thousand_separator" => ",", "decimal_separator" => ".", "created_at" => NULL , "updated_at" => NULL ],
		[ "id" => "122", "country" => "Ukraine", "currency" => "Hryvnia", "code" => "UAH", "symbol" => "₴", 
		"thousand_separator" => ",", "decimal_separator" => ".", "created_at" => NULL , "updated_at" => NULL ],
		[ "id" => "123", "country" => "United Kingdom", "currency" => "Pounds", "code" => "GBP", "symbol" => "£", 
		"thousand_separator" => ",", "decimal_separator" => ".", "created_at" => NULL , "updated_at" => NULL ],
		[ "id" => "124", "country" => "United States of America", "currency" => "Dollars", "code" => "USD", "symbol" => '$', 
		"thousand_separator" => ",", "decimal_separator" => ".", "created_at" => NULL , "updated_at" => NULL ],
		[ "id" => "125", "country" => "Uruguay", "currency" => "Pesos", "code" => "UYU", "symbol" => '$U', 
		"thousand_separator" => ",", "decimal_separator" => ".", "created_at" => NULL , "updated_at" => NULL ],
		[ "id" => "126", "country" => "Uzbekistan", "currency" => "Sums", "code" => "UZS", "symbol" => "лв", 
		"thousand_separator" => ",", "decimal_separator" => ".", "created_at" => NULL , "updated_at" => NULL ],
		[ "id" => "127", "country" => "Vatican City", "currency" => "Euro", "code" => "EUR", "symbol" => "€", 
		"thousand_separator" => ".", "decimal_separator" => ",", "created_at" => NULL , "updated_at" => NULL ],
		[ "id" => "128", "country" => "Venezuela", "currency" => "Bolivares Fuertes", "code" => "VEF", "symbol" => "Bs", 
		"thousand_separator" => ",", "decimal_separator" => ".", "created_at" => NULL , "updated_at" => NULL ],
		[ "id" => "129", "country" => "Vietnam", "currency" => "Dong", "code" => "VND", "symbol" => "₫", 
		"thousand_separator" => ",", "decimal_separator" => ".", "created_at" => NULL , "updated_at" => NULL ],
		[ "id" => "130", "country" => "Yemen", "currency" => "Rials", "code" => "YER", "symbol" => "﷼", 
		"thousand_separator" => ",", "decimal_separator" => ".", "created_at" => NULL , "updated_at" => NULL ],
		[ "id" => "131", "country" => "Zimbabwe", "currency" => "Zimbabwe Dollars", "code" => "ZWD", "symbol" => "Z$", 
		"thousand_separator" => ",", "decimal_separator" => ".", "created_at" => NULL , "updated_at" => NULL ],
		[ "id" => "132", "country" => "Iraq", "currency" => "Iraqi dinar", "code" => "IQD", "symbol" => "د.ع", 
		"thousand_separator" => ",", "decimal_separator" => ".", "created_at" => NULL , "updated_at" => NULL ],
		[ "id" => "133", "country" => "Kenya", "currency" => "Kenyan shilling", "code" => "KES", "symbol" => "KSh", 
		"thousand_separator" => ",", "decimal_separator" => ".", "created_at" => NULL , "updated_at" => NULL ],
		["id" => "134", "country" => "Bangladesh", "currency" => "Taka", "code" => "BDT", "symbol" => "৳", "thousand_separator" => ",", "decimal_separator" => ".", "created_at" => NULL , "updated_at" => NULL ]
    	);

		Currency::insert($data);

		Currency::insert(["country" => "Algerie", "currency" => "Algerian dinar", "code" => "DZD", "symbol" => "د.ج", "thousand_separator" => " ", "decimal_separator" => ".", "created_at" => NULL , "updated_at" => NULL ]);




    }
}