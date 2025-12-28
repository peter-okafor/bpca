<?php

namespace Database\Seeders;

use App\Models\Locality;
use Illuminate\Database\Seeder;

class CountiesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     * @return void
     */
    public function run()
    {
        $counties = [
            "Aberdeen City", "Aberdeenshire", "Angus", "Antrim", "Ards", "Argyll and
Bute", "Armagh", "Ballymena", "Ballymoney", "Banbridge", "Barking & Dagenham, Greater London", "Barnet, Greater
London", "Bedfordshire", "Belfast", "Berkshire", "Bexley, Greater London", "Blaenau Gwent", "Brent, Greater
London", "Bridgend", "Bristol", "Bromley, Greater London", "Buckinghamshire", "Caerphilly", "Cambridgeshire", "Camden, Greater
London", "Cardiff", "Carmarthenshire", "Carrickfergus", "Castlereagh", "Ceredigion", "Cheshire", "City of Edinburgh", "City of
London, Greater London", "Clackmannanshire", "Coleraine", "Conwy", "Cookstown", "Cornwall", "County
Durham", "Craigavon", "Croydon, Greater
London", "Cumbria", "Denbighshire", "Derbyshire", "Derry", "Devon", "Dorset", "Down", "Dumfries and Galloway", "Dundee
City", "Dungannon", "Ealing, Greater London", "East Ayrshire", "East Dunbartonshire", "East Lothian", "East
Renfrewshire", "East Riding of Yorkshire", "East Sussex", "Enfield, Greater
London", "Essex", "Falkirk", "Fermanagh", "Fife", "Flintshire", "Glasgow City", "Gloucestershire", "Greater
Manchester", "Greenwich, Greater London", "Gwynedd", "Hackney, Greater London", "Hammersmith & Fulham, Greater
London", "Hampshire", "Haringey, Greater London", "Harrow, Greater London", "Havering, Greater
London", "Herefordshire", "Hertfordshire", "Highland", "Hillingdon, Greater London", "Hounslow, Greater
London", "Inverclyde", "Isle of Anglesey", "Isle of Wight", "Isles of Scilly", "Islington, Greater London", "Kensington &
Chelsea, Greater London", "Kent", "Kingston upon Thames, Greater London", "Lambeth, Greater
London", "Lancashire", "Larne", "Leicestershire", "Lewisham, Greater
London", "Limavady", "Lincolnshire", "Lisburn", "Magherafelt", "Merseyside", "Merthyr Tydfil", "Merton, Greater
London", "Midlothian", "Monmouthshire", "Moray", "Moyle", "Na h-Eileanan an Iar", "Neath Port Talbot", "Newham, Greater
London", "Newport", "Newry and Mourne", "Newtownabbey", "Norfolk", "North Ayrshire", "North Down", "North Lanarkshire", "North
Yorkshire", "Northamptonshire", "Northumberland", "Nottinghamshire", "Omagh", "Orkney
Islands", "Oxfordshire", "Pembrokeshire", "Perth and Kinross", "Powys", "Redbridge, Greater London", "Renfrewshire", "Rhondda
Cynon Taf", "Richmond upon Thames, Greater London", "Rutland", "Scottish Borders", "Shetland
Islands", "Shropshire", "Somerset", "South Ayrshire", "South Lanarkshire", "South Yorkshire", "Southwark, Greater
London", "Staffordshire", "Stirling", "Strabane", "Suffolk", "Surrey", "Sutton, Greater London", "Swansea", "The Vale of
Glamorgan", "Torfaen", "Tower Hamlets, Greater London", "Tyne and Wear", "Waltham Forest, Greater London", "Wandsworth,
Greater London", "Warwickshire", "West Dunbartonshire", "West Lothian", "West Midlands", "West Sussex", "West
Yorkshire", "Westminster, Greater London", "Wiltshire", "Worcestershire", "Wrexham"
        ];

        foreach ($counties as $county) {

            Locality::updateOrCreate([
                'name' => $county
            ], [
                'name' => $county,
                'description' => $county
            ]);
        }
    }
}
