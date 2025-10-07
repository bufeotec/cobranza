const fecha = new Date();
const fechaLocal = fecha.getFullYear() + "-" +
    ("0" + (fecha.getMonth() + 1)).slice(-2) + "-" +
    ("0" + fecha.getDate()).slice(-2) + " " +
    ("0" + fecha.getHours()).slice(-2) + ":" +
    ("0" + fecha.getMinutes()).slice(-2) + ":" +
    ("0" + fecha.getSeconds()).slice(-2);


function cambia() {
    var opt_Amazonas = new Array ("Seleccione la Provincia", "Bagua", "Bongará", "Chachapoyas", "Condorcanqui","Luya","Rodríguez de Mendoza","Utcubamba");
    var opt_Amazonas_value = new Array ("Seleccione la Provincia", "Bagua", "Bongará", "Chachapoyas", "Condorcanqui","Luya","Rodríguez_de_Mendoza","Utcubamba");

    var opt_Ancash = new Array ("Seleccione la Provincia", "Aija", "Antonio Raymondi", "Asunción", "Bolognesi","Carhuaz","Carlos Fermín Fitzcarrald","Casma","Corongo","Huaraz","Huari","Huarmey","Huaylas","Mariscal Luzuriaga","Ocros","Pallasca","Pomabamba","Recuay","Santa","Sihuas","Yungay");
    var opt_Ancash_value = new Array ("Seleccione la Provincia", "Aija", "Antonio_Raymondi", "Asunción", "Bolognesi","Carhuaz","Carlos_Fermín_Fitzcarrald","Casma","Corongo","Huaraz","Huari","Huarmey","Huaylas","Mariscal_Luzuriaga","Ocros","Pallasca","Pomabamba","Recuay","Santa","Sihuas","Yungay");

    var opt_Apurímac = new Array ("Seleccione la Provincia", "Abancay", "Andahuaylas", "Antabamba", "Aymaraes","Cotabambas","Chincheros","Grau");
    var opt_Apurímac_value = new Array ("Seleccione la Provincia", "Abancay", "Andahuaylas", "Antabamba", "Aymaraes","Cotabambas","Chincheros","Grau");

    var opt_Arequipa = new Array ("Seleccione la Provincia", "Arequipa", "Camaná", "Caravelí", "Castilla","Caylloma","Condesuyos","Islay","La Unión");
    var opt_Arequipa_value = new Array ("Seleccione la Provincia", "Arequipa", "Camaná", "Caravelí", "Castilla","Caylloma","Condesuyos","Islay","La_Unión");

    var opt_Ayacucho = new Array ("Seleccione la Provincia", "Cangallo","Huamanga","Huanca Sancos", "Huanta","La Mar","Lucanas","Parinacochas","Páucar del Sara Sara","Sucre","Víctor Fajardo","Vilcashuamán");
    var opt_Ayacucho_value = new Array ("Seleccione la Provincia", "Cangallo","Huamanga","Huanca_Sancos", "Huanta","La_Mar","Lucanas","Parinacochas","Páucar_del_Sara_Sara","Sucre","Víctor_Fajardo","Vilcashuamán");

    var opt_Cajamarca = new Array ("Seleccione la Provincia", "Cajabamba","Cajamarca ","Celendín", "Contumazá","Cutervo","Chota","Hualgayoc","Jaén","Santa Cruz","San Miguel","San Ignacio","San Marcos","San Pablo");
    var opt_Cajamarca_value = new Array ("Seleccione la Provincia", "Cajabamba","Cajamarca ","Celendín", "Contumazá","Cutervo","Chota","Hualgayoc","Jaén","Santa_Cruz","San_Miguel","San_Ignacio","San_Marcos","San_Pablo");

    var opt_Callao = new Array ("Seleccione la Provincia", "Callao");
    var opt_Callao_value = new Array ("Seleccione la Provincia", "Callao");

    var opt_Cuzco = new Array ("Seleccione la Provincia", "Acomayo","Anta ","Calca", "Canas","Canchis","Chumbivilcas","Cuzco","Espinar","La Convención","Paruro","Paucartambo","Quispicanchi","Urubamba");
    var opt_Cuzco_value = new Array ("Seleccione la Provincia", "Acomayo","Anta ","Calca", "Canas","Canchis","Chumbivilcas","Cuzco","Espinar","La_Convención","Paruro","Paucartambo","Quispicanchi","Urubamba");

    var opt_Huancavelica = new Array ("Seleccione la Provincia", "Acobamba","Angaraes ","Castrovirreyna", "Churcampa","Huancavelica","Huaytará","Tayacaja");
    var opt_Huancavelica_value = new Array ("Seleccione la Provincia", "Acobamba","Angaraes ","Castrovirreyna", "Churcampa","Huancavelica","Huaytará","Tayacaja");

    var opt_Huánuco = new Array ("Seleccione la Provincia", "Ambo","Dos de Mayo","Huacaybamba", "Huánuco","Huamalíes","Leoncio Prado","Marañón","Pachitea","Puerto Inca","Lauricocha","Yarowilca");
    var opt_Huánuco_value = new Array ("Seleccione la Provincia", "Ambo","Dos_de_Mayo","Huacaybamba", "Huánuco","Huamalíes","Leoncio_Prado","Marañón","Pachitea","Puerto_Inca","Lauricocha","Yarowilca");

    var opt_Ica = new Array ("Seleccione la Provincia","Chincha","Ica","Nazca","Palpa","Pisco");
    var opt_Ica_value = new Array ("Seleccione la Provincia","Chincha","Ica","Nazca","Palpa","Pisco");

    var opt_Junín = new Array ("Seleccione la Provincia", "Concepción","Chanchamayo","Chupaca","Huancayo","Jauja","Junín","Satipo","Tarma","Yauli");
    var opt_Junín_value = new Array ("Seleccione la Provincia", "Concepción","Chanchamayo","Chupaca","Huancayo","Jauja","Junín","Satipo","Tarma","Yauli");

    var opt_La_Libertad= new Array ("Seleccione la Provincia", "Ascope","Bolívar","Chepén","Gran Chimú","Julcán","Otuzco","Pacasmayo","Pataz","Sánchez Carrión","Santiago de Chuco","Trujillo","Virú");
    var opt_La_Libertad_value= new Array ("Seleccione la Provincia","Ascope","Bolívar","Chepén","Gran_Chimú","Julcán","Otuzco","Pacasmayo","Pataz","Sánchez_Carrión","Santiago_de_Chuco","Trujillo","Virú");

    var opt_Lambayeque= new Array ("Seleccione la Provincia", "Chiclayo","Ferreñafe","Lambayeque");
    var opt_Lambayeque_value= new Array ("Seleccione la Provincia", "Chiclayo","Ferreñafe","Lambayeque");

    var opt_Lima= new Array ("Seleccione la Provincia","Barranca","Cajatambo","Canta","Cañete","Huaral","Huarochirí","Huaura","Lima","Oyón","Yauyos");
    var opt_Lima_value= new Array ("Seleccione la Provincia","Barranca","Cajatambo","Canta","Cañete","Huaral","Huarochirí","Huaura","Lima","Oyón","Yauyos");

    var opt_Loreto= new Array ("Seleccione la Provincia","Alto Amazonas","Datem del Marañón","Loreto","Maynas","Mariscal Ramón Castilla","Putumayo","Requena","Ucayali");
    var opt_Loreto_value= new Array ("-","Alto_Amazonas","Datem_del_Marañón","Loreto","Maynas","Mariscal_Ramón_Castilla","Putumayo","Requena","Ucayali");

    var opt_Madre_de_Dios=new Array("Seleccione Provincia","Manu","Tambopata","Tahuamanu");
    var opt_Madre_de_Dios_value=new Array("Seleccione Provincia","Manu","Tambopata","Tahuamanu");

    var opt_Moquegua=new Array("Seleccione Provincia","General Sánchez Cerro","Ilo","Mariscal Nieto");
    var opt_Moquegua_value=new Array("Seleccione Provincia","General_Sánchez_Cerro","Ilo","Mariscal_Nieto");

    var opt_Pasco=new Array("Seleccione Provincia","Daniel Alcides Carrión","Oxapampa","Pasco");
    var opt_Pasco_value=new Array("Seleccione Provincia","Daniel_Alcides_Carrión","Oxapampa","Pasco");

    var opt_Piura=new Array("Seleccione Provincia","Ayabaca","Huancabamba","Morropón","Paita","Piura","Sechura","Sullana","Talara");
    var opt_Piura_value=new Array("Seleccione Provincia","Ayabaca","Huancabamba","Morropón","Paita","Piura","Sechura","Sullana","Talara");

    var opt_Puno=new Array("Seleccione Provincia","Azángaro","Carabaya","Chucuito","El Collao","Huancané","Lampa","Melgar","Moho","Puno","San Antonio de Putina","San Román","Sandia","Yunguyo");
    var opt_Puno_value=new Array("Seleccione Provincia","Azángaro","Carabaya","Chucuito","El_Collao","Huancané","Lampa","Melgar","Moho","Puno","San_Antonio_de_Putina","San_Román","Sandia","Yunguyo");

    var opt_San_Martín=new Array("Seleccione Provincia","Bellavista","El Dorado","Huallaga","Lamas","Mariscal Cáceres","Moyobamba","Picota","Rioja","San Martín","Tocache");
    var opt_San_Martín_value=new Array("Seleccione Provincia","Bellavista","El_Dorado","Huallaga","Lamas","Mariscal_Cáceres","Moyobamba","Picota","Rioja","San_Martín","Tocache");

    var opt_Tacna=new Array("Seleccione Provincia","Candarave","Jorge Basadre","Tacna","Tarata");
    var opt_Tacna_value=new Array("Seleccione Provincia","Candarave","Jorge_Basadre","Tacna","Tarata");

    var opt_Tumbes=new Array("Seleccione Provincia","Contralmirante Villar","Tumbes","Zarumilla");
    var opt_Tumbes_value=new Array("Seleccione Provincia","Contralmirante_Villar","Tumbes","Zarumilla");

    var opt_Ucayali=new Array("Seleccione Provincia","Atalaya","Coronel Portillo","Padre Abad","Purús");
    var opt_Ucayali_value=new Array("Seleccione Provincia","Atalaya","Coronel_Portillo","Padre_Abad","Purús");


    var cosa;
    selectDepartamento = document.getElementById('selectDepartamento').value;

    if(selectDepartamento!=0)
    {
        mis_opts=eval("opt_" + selectDepartamento);
        mis_value=eval("opt_" + selectDepartamento +"_value");

        num_opts=mis_opts.length;

        document.getElementById('selectProvincia').length = num_opts;

        for(i=0; i<num_opts; i++)
        {
            document.getElementById('selectProvincia').options[0].value="";
            document.getElementById('selectProvincia').options[0].text="Seleccione la Provincia";


            document.getElementById('selectProvincia').options[i].value=mis_value[i];
            document.getElementById('selectProvincia').options[i].text=mis_opts[i];
        }

        document.getElementById('selectDistrito').length = 1;
        document.getElementById('selectDistrito').options[0].value=" ";
        document.getElementById('selectDistrito').options[0].text="Seleccione el Distrito";


    }
    else
    {
        document.getElementById('selectProvincia').length = 1;
        document.getElementById('selectProvincia').options[0].value="";
        document.getElementById('selectProvincia').options[0].text="Seleccione la Provincia";
    }
    document.getElementById('selectProvincia').options[0].selected = true;
    document.getElementById('selectDistrito').options[0].selected = true;
}


var opt_Bagua = new Array ("Seleccione el Distrito","Aramago", "Bagua", "Copallín", "Chiriaco","El Parco","La Peca");
var opt_Bongará = new Array ("Seleccione el Distrito","Chisquilla","Churuja","Corosha","Cuipes","Florida","Jazán","Jumbilla","Recta","San Carlos","Shipasbamba","Valera","Yambrasbamba");
var opt_Chachapoyas = new Array ("Seleccione el Distrito","Asunsión","Balsas","Chachapoyas","Cheto","Chiliquín","Chuquibamba","Granada","Huancas","La Jalca","Leimebamba","Levanto","Magdalena","Mariscal Castilla","Molinopampa","Montevideo","Olleros","Quinjalca","San Francisco de Daguas","San Isidro de Maino","Soloco","Sonche");
var opt_Condorcanqui =new Array ("Seleccione el Distrito","El Cenepa","Nieva","Río Santiago");
var opt_Luya =new Array ("Seleccione el Distrito","Camporredondo","Cocabamba","Colcamar","Conila","Inguilpata","Lámud","Longuita","Lonya Chico","Luya","Luya Viejo","María","Ocalli","Ocumal","Pisuquía","Providencia","San Cristóbal","San Francisco del Yeso","San Jerónimo","San Juan de Lopecancha","Santa Catalina","Santo Tomás","Tingo","Trita");
var opt_Rodríguez_de_Mendoza = new Array ("Seleccione el Distrito","San Nicolás","Chirimoto","Cochamal","Huambo","Limababa","Longar","Mariscal Benavides","Milpuc","Omia","Santa Rosa","Totora","Vista Alegre");
var opt_Utcubamba =new Array ("Seleccione el Distrito","Bagua Grande","Cajaruro","Cumba","El Milagro","Jamalca","Lonya Grande","Yamón");

var opt_Aija =new Array ("Seleccione el Distrito","Aija","Coris","Huacllán","La Merced","Succha");
var opt_Antonio_Raymondi =new Array ("Seleccione el Distrito","Llamellín","Aczo","Chaccho","Chingas","Mirgas","San Juan de Rontoy");
var opt_Asunción =new Array("Seleccione el Distrito","Chacas","Acochaca");
var opt_Bolognesi =new Array("Seleccione el Distrito","Abelardo Pardo","Antonio Raymondi","Aquia","Cajatay","Canis","Chiquián","Cólquioc","Huallanca","Huasta","Huayllacayán","La Primavera","Mangas","Pacllón","San Miguel","Ticllos");
var opt_Carhuaz =new Array("Seleccione el Distrito","Acopampa","Amashca","Anta","Ataquero","Carhuaz","Marcará","Pariahuanca","San Miguel de Aco","Shilla","Tinco","Yungar");
var opt_Carlos_Fermín_Fitzcarrald =new Array("Seleccione el Distrito","San Luis","San Nicolás","Yauya");
var opt_Casma =new Array("Seleccione el Distrito","Buenavista","Casma","Comandante Noel","Yaután");
var opt_Corongo =new Array("Seleccione el Distrito","Aco","Bambas","Corongo","Cusca","La Pampa","Yánac","Yupán");
var opt_Huaraz =new Array("Seleccione el Distrito","Cochabamba","Colcabamba","Huanchay","Huaraz","Indepedencia","Jangas","La Libertad","Olleros","Pampas Grande","Pariacoto","Pira","Tarica");
var opt_Huari =new Array("Seleccione el Distrito","Anra","Cajay","Chavín de Huántar","Huacachi","Huacchis","Huachis","Huántar","Huari","Masin","Paucas","Pontó","Rahuapampa","Rapayán","San Marcos","San Pedro de Chaná","Uco");
var opt_Huarmey =new Array("Seleccione el Distrito","Cochapeti","Culebras","Huarmey","Huayan","Malvas");
var opt_Huaylas =new Array("Seleccione el Distrito","Caraz","Huallanca","Huanta","Huaylas","Mato","Pamparomás","Pueblo Libre","Santa Cruz","Santo Toribio","Yuracmarca");
var opt_Mariscal_Luzuriaga =new Array("Seleccione el Distrito","Casca","Eleazar Guzmán Barrón","Fidel Olivas Escudero","Llama","Llumpa","Lucma","Musga","Piscobamba");
var opt_Ocros =new Array("Seleccione el Distrito","Acas","Cajamarquilla","Carhuapampa","Cochas","Congas","Llipa","Ocros","San Cristóbal de Raján","San Pedro","Santiago de Chilcas");
var opt_Pallasca =new Array("Seleccione el Distrito","Bolognesi","Cabana","Conchucos","Huacaschuque","Huandoval","Lacabamba","Llapo","Pallasca","Pampas","Santa Rosa","Tauca");
var opt_Pomabamba =new Array("Seleccione el Distrito","Huayllán","Parobamba","Pomabamba","Quinuabamba");
var opt_Recuay =new Array("Seleccione el Distrito","Catac","Cotaparaco","Huayllapampa","Llacllín","Marca","Pampas Chico","Pararín","Recuay","Tapacocha","Ticapampa");
var opt_Santa =new Array("Seleccione el Distrito","Cáceres del Perú","Chimbote","Coishco","Macate","Moro","Nepeña","Nuevo Chimbote","Samanco","Santa");
var opt_Sihuas =new Array("Seleccione el Distrito","Acobamba","Alfonso Ugarte","Cashapampa","Chingalpo","Huayllabamba","Quiches","Ragash","San Juan","Sicsibamba","Sihuas");
var opt_Yungay =new Array("Seleccione el Distrito","Cascapara","Mancos","Matacoto","Quillo","Ranrahirca","Shupluy","Yanama","Yungay");

var opt_Abancay = new Array ("Seleccione el Distrito", "Abancay", "Chacoche", "Circa", "Curahuasi","Huanipaca","Lambrama","Pichirhua","San Pedro de Cachora","Tamburco");
var opt_Andahuaylas = new Array ("Seleccione el Distrito", "Andahuaylas", "Adarapa", "Chiara", "Huancarama","Huancaray","Huayana","José María Arguedas","Kiquiabamba","Kishuara","Pacobamba","Pacucha","Pampachiri","Pamacocha","San Antonio de Cachi","San Jerónimo","San Miguel de Chaccrapampa","Santa María de Chicmo","Talavera de la Reyna","Tumay Huaraca","Turpo");
var opt_Antabamba = new Array ("Seleccione el Distrito","Antabamba","El Oro","Huaquirca","Juan Espinoza Medrano","Oropesa","Pachaconas","Sabaino");
var opt_Aymaraes = new Array ("Seleccione el Distrito","Capaya","Caraybamba","Chalhuanca","Chapimarca","Colcabamba","Cotaruse","Ihuayllo","Justo Apu Sahuaraura","Lucre","Pocohuanca","San Juan de Chacña","Sañayca","Soraya","Tapayrihua","Tintay","Toraya","Yanaca");
var opt_Cotabambas = new Array ("Seleccione el Distrito","Chalhuahuachos","Cotabambas","Coyllurqui","Haquira","Mara","Tambobamba");
var opt_Chincheros = new Array ("Seleccione el Distrito","Anccohuayllo","Chincheros","Cocharcas","Huaccana","Ocobamba","Ongoy","Uranmarca","Ranracancha","Rocchac","El Porvenir","Los Chanckas");
var opt_Grau = new Array ("Seleccione el Distrito","Chuquibambilla","Curasco","Curpahuasi","Huayllati","Mamara","Mariscal Gamarra","Micaela Bastidas","Pataypampa","Progreso","San Antonio","Santa Rosa","Turpay","Vilcabamba","Virundo");

var opt_Arequipa = new Array ("Seleccione el Distrito","Alto Selva Alegre","Arequipa","Cayma","Cerro Colorado","Characato","Chiguata","Jacobo Hunter","José Luis Bustamante y Rivero","La Joya","Mariano Melgar","Miraflores","Mollebamba","Paucarpata","Pocsi","Polobaya","Quequeña","Sabandía","Sachaca","San Juan de Siguas","San Juan de Tarucani","Santa Isabel de Siguas","Santa Rita de Siguas","Socabaya","Tiabaya","Uchumayo","Vitor","Yanahuara","Yarabamba","Yura");
var opt_Camaná = new Array ("Seleccione el Distrito","Camaná","José María Quimper","Mariano Nicolás Valcarcel","Mariscal Cáceres","Nicolás de Piérola","Ocoña","Quilca","Samuel Pastor");
var opt_Caravelí = new Array ("Seleccione el Distrito","Acarí","Atico","Atiquipa","Bella Unión","Cahuacho","Caravelí","Chala","Cháparra","Huanuhuanu","Jaqui","Lomas","Quicacha","Yauca");
var opt_Castilla = new Array ("Seleccione el Distrito","Andara","Aplao","Ayo","Chachas","Chilcaymarca","Choco","Huancarqui","Mochaguay","Orcopampa","Pampacolca","Tipán","Uñón","Uraca","Viraco");
var opt_Caylloma = new Array ("Seleccione el Distrito","Achoma","Cabanaconde","Callalli","Caylloma","Chivay","Coporaque","Huambo","Huanca","Ichupampa","Lari","Lluta","Maca","Madrigal","Majes","San Antonio de Chuca","Sibayo","Tapay","Tisco","Tuti","Yanque");
var opt_Condesuyos = new Array ("Seleccione el Distrito","Andaray","Cayarani","Chichas","Chuquibamba","Iray","Rio Grande","Salamanca","Yanaquihua");
var opt_Islay = new Array ("Seleccione el Distrito","Cacachacra","Deán Valdivia","Islay","Mejía","Mollendo","Punta de Bombón");
var opt_La_Unión = new Array ("Seleccione el Distrito","Alca","Charcana","Cotahuasi","Huaynacotas","Pampamarca","Puyca","Quechualla","Sayla","Tauría","Tomepampa","Toro");

var opt_Cangallo = new Array ("Seleccione el Distrito","Cangallo","Chuschi","Los Morochucos","María Parado de Bellido","Paras","Totos");
var opt_Huamanga = new Array ("Seleccione el Distrito","Acocro","Acos Vinchos","Andrés Avelino Cáceres Dorregaray","Ayacucho","Carmen Alto","Chiara","Jesús Nazareno","Ocros","Pacaycasa","Quinua","San José de Ticllas","San Juan Bautista","Santiago de Pischa","Socos","Tambillo","Vinchos");
var opt_Huanca_Sancos = new Array ("Seleccione el Distrito","Carapo","Sacsamarca","Sancos","Santiago de Lucanamarca");
var opt_Huanta = new Array ("Seleccione el Distrito","Ayahuanco","Huamanguilla","Huanta","Iguaín","Llochegua","Luricocha","Santillana","Sivia","Canayre","Uchuraccay","Pucacolpa","Chaca");
var opt_La_Mar = new Array ("Seleccione el Distrito","Anchihuay","Anco","Ayna","Chilcas","Chungui","Luis Carranza","Oronccoy","San Miguel","Santa Rosa","Sumugari","Tambo");
var opt_Lucanas = new Array ("Seleccione el Distrito","Aucara","Cabana Sur","Carmen Salcedo","Chaviña","Chipao","Huacuas","Laramate","Leoncio Prado","Llauta","Lucanas","Ocaña","Otoca","Puquio","Saisa","San Cristóbal","San Juan","San Pedro","San Pedro de Palco","Sancos","Santa Ana de Huaycahuacho","Santa Lucía");
var opt_Parinacochas = new Array ("Seleccione el Distrito","Coracora","Chumpi","Coronel Castañeda","Pacapausa","Pullo","Puyasca","San Francisco de Ravacayco","Upahuacho");
var opt_Páucar_del_Sara_Sara = new Array ("Seleccione el Distrito","Colta","Corculla","Lampa","Marcabamba","Oyolo","Pararca","Pauza","San Javier de Alpabamba","San José de Ushua","Sara Sara");
var opt_Sucre = new Array ("Seleccione el Distrito","Belén","Chalcos","Chilcayoc","Huacaña","Morcolla","Paico","Querobamba","San Pedro de Larcay","San Salvador de Quije","Santiago de Paucaray","Soras");
var opt_Víctor_Fajardo = new Array ("Seleccione el Distrito","Alcamenca","Apongo","Asquipata","Canaria","Cayana","Colca","Huamanquiquia","Huancapi","Huancaraylla","Huaya","Sahua","Vilcanchos");
var opt_Vilcashuamán = new Array ("Seleccione el Distrito","Accomarca","Carhuanca","Concepción","Huambalpa","Independencia","Saurama","Vilvashuamán","Vischongo");

var opt_Cajabamba = new Array ("Seleccione el Distrito","Cachachi","Cajabamba","Condebamba","Sitacocha");
var opt_Cajamarca = new Array ("Seleccione el Distrito","Asunsión","Cajamarca","Chetilla","Cospán","Jesús","LLacanora","La Encañada","Los Baños del Inca","Magdalena","Matara","Nomora","San Juan");
var opt_Celendín = new Array ("Seleccione el Distrito","Celendín","Chumuch","Cortegana","Huasmin","Jorge Chávez","José Galvez","La Libertad de Pallán","Miguel Iglesias","Oxamarca","Sorochuco","Sucre","Utco");
var opt_Contumazá = new Array ("Seleccione el Distrito","Chilete","Contumazá","Cupisnique","Guzmango","San Benito","Santa Cruz de Toledo","Tantarica","Yonán");
var opt_Cutervo = new Array ("Seleccione el Distrito","Callayuc","Choros","Cujillo","Cutervo","La Ramada","<Pinpin></Pinpin>gos","Querocotillo","San Andrés de Cutervo","San Juan de Cutervo","San Luis de Lucma","Santa Cruz","Santo Domingo de la Capilla","Santo Tomás","Socota","Toribio Casanova");
var opt_Chota = new Array ("Seleccione el Distrito","Anguía","Chadín","Chalamarca","Chiguirip","Chimban","Choropampa","Chota","Cochabamba","Conchán","Huambos","Lajas","Llama","Miracosta","Paccha","Pion","Querocoto","San Juan de Licupis","Tacabamba","Tocmoche");
var opt_Hualgayoc = new Array ("Seleccione el Distrito","Bambamarca","Chugur","Hualgayoc");
var opt_Jaén = new Array ("Seleccione el Distrito","Bellavista","Chontalí","Colasay","Huabal","Jaén","Las Pirias","Pomahuanca","Pucará","Sallique","San Felipe","San José del Alto","Santa Rosa");
var opt_Santa_Cruz = new Array ("Seleccione el Distrito","Andabamba","Catache","Chancaybaños","La Esperanza","Ninabamba","Pulán","Santa Cruz","Saucepampa","Sexi","Uticyacu","Yauyucan","Idima");
var opt_San_Miguel = new Array ("Seleccione el Distrito","Bolívar","Calquis","Catilluc","El Prado","La Florida","Llapa","Nanchoc","Niepos","San Gregorio","San Miguel","San Silvestre de Conchán","Tongod","Unión Agua Blanca");
var opt_San_Ignacio = new Array ("Seleccione el Distrito","Chirinos","Huarango","La Coipa","Namballe","San Ignacio","San José de Lourdes","Tabaconas");
var opt_San_Marcos = new Array ("Seleccione el Distrito","Chancay","Eduardo Villanueva","Gregorio Pita","Ichocán","Jose Manuel Quiroz","José Sagobal","Pedro Gálvez");
var opt_San_Pablo = new Array ("Seleccione el Distrito","San Bernardino","San Luis","San Pablo","Tumbaden");

var opt_Callao = new Array ("Seleccione el Distrito", "Bellavista","Callao","Carmen de la Legua","La Perla","La Punta","Ventanilla","Mi Perú");

var opt_Acomayo = new Array ("Seleccione el Distrito","Acomayo","Acopia","Acos","Mosoc Llacta","Pomacanchi","Rondocan","Sangarará");
var opt_Anta = new Array ("Seleccione el Distrito","Anta","Ancahuasi","Cachimayo","Chinchaypujio","Huarocondo","Limatambo","Mollepata","Pucyura","Zurite");
var opt_Calca = new Array ("Seleccione el Distrito","Calca","Coya","Lamay","Lares","Pisac","San Salvador","Taray","Yanatile");
var opt_Canas = new Array ("Seleccione el Distrito","Checca","Kunturkanki","Langui","Layo","Pampamarca","Quehue","Túpac Amaru","Yanaoca");
var opt_Canchis = new Array ("Seleccione el Distrito","Checacupe","Combapata","Marangani","Pitumarca","San Pablo","San Pedro","Sicuani","Tinta");
var opt_Chumbivilcas = new Array ("Seleccione el Distrito","Ccapacmarca","Chamaca","Colquemarca","Livitaca","Llusco","Quiñota","Santo Tomás","Valille");
var opt_Cuzco = new Array ("Seleccione el Distrito","Ccorca","Cuzco","Poroy","San Jerónimo","San Sebastián","Santiago","Saylla","Wanchaq");
var opt_Espinar = new Array ("Seleccione el Distrito","Alto Pichigua","Condoroma","Coporaque","Ocoruro","Pallpata","Pichigua","Suyckutambo","Yauri");
var opt_La_Convención = new Array ("Seleccione el Distrito","Echarati","Huayopata","Inkawasi","Kimbiri","Maranura","Megantoni","Ocobamba","Pachari","Quellouno","Santa Ana","Santa Teresa","Vilcabamba","Villa Kintiarina","Villa Virgen");
var opt_Paruro = new Array ("Seleccione el Distrito","Accha","Ccapi","Colcha","Huanoquite","Omacha","Paccaritambo","Paruro","Pillpinto","Yaurisque");
var opt_Paucartambo = new Array ("Seleccione el Distrito","Caicay","Challabamba","Colquepata","Huancarani","Kosñipata","Paucartambo");
var opt_Quispicanchi = new Array ("Seleccione el Distrito","Andahuaylillas","Camanti","Ccarhuayo","Ccatca","Cusipata","Huaro","Lucre","Marcapata","Ocongate","Oropesa","Quiquijana","Urcos");
var opt_Urubamba = new Array ("Seleccione el Distrito","Chinchero","Huayllabamba","Machupicchu","Maras","Ollantaytambo","Urubamba","Yucay");

var opt_Acobamba = new Array ("Seleccione el Distrito","Acobamba","Andabamba","Anta","Caja","Marcas","Paucará","Pomacocha","Rosario");
var opt_Angaraes = new Array ("Seleccione el Distrito","Anchonga","Callanmarca","Ccochaccasa","Chincho","Congalla","Huanca Huanca","Huayllay Grande","Julcamarca","Lircay","San Antonio de Antaparco","Santo Tomás de Pata","Secila");
var opt_Castrovirreyna = new Array ("Seleccione el Distrito","Arma","Aurahuá","Capillas","Castrovirreyna","Chupamarca","Cocas","Huachos","Huamatambo","Mollepampa","San Juan","Santa Ana","Tantara","Ticrapo");
var opt_Churcampa = new Array ("Seleccione el Distrito","Anco","Chinchihuasi","Churcampa","Cosme","El Carmen","La Merced","Locroja","Pachamarca","Paucarbamba","San Miguel de Mayocc","San Pedro de Coris");
var opt_Huancavelica = new Array ("Seleccione el Distrito","Acobambilla","Acoria","Ascensión","Conayca","Cuenca","Huachocolpa","Huando","Huancavelica","Huayllahuara","Izcuchaca","Laria","Manta","Mariscal Cáceres","Moya","Nuevo Occoro","Palca","Pilchaca","Vilva","Yauli");
var opt_Huaytará = new Array ("Seleccione el Distrito","Ayaví","Córdoba","Huayacundo Arma","Huaytará","Laramarca","Ocoyo","Pilpichaca","Querco","Quito-Arma","San Antonio de Cusicancha","San Francisco de Sangayaico","San Isisdro","Santiago de Chocorvos","Santiago de Quirahuara","Santo Domingo de Capillas","Tambo");
var opt_Tayacaja = new Array ("Seleccione el Distrito","Acostambo","Acraquía","Ahuaycha","Andaymarca","Colcabamba","Daniel Hernández","Huachocolpa","Huaribamba","Ñahuimpuquio","Pampas","Pazos","Pichos","Roble","Quichuas","Quishuar","Salcabamba","Salcahuasi","San Marcos de Rocchac","Santiago de Tucuma","Surcubamba","Tintay Puncu");

var opt_Ambo = new Array ("Seleccione el Distrito","Ambo","Cayna","Colpas","Conchamarca","Huácar","San Francisco","San Rafael","Tomay Kichwa");
var opt_Dos_de_Mayo = new Array ("Seleccione el Distrito","Chuquis","La Unión","Marías","Pachas","Quivilla","Ripán","Shunqui","Sillapata","Yanas");
var opt_Huacaybamba = new Array ("Seleccione el Distrito","Canchabamba","Cochabamba","Huacaybamba","Pinra");
var opt_Huánuco = new Array ("Seleccione el Distrito","Amarillis","Chinchao","Churumbamba","Huánuco","Margos","Pillco Marca","Quisqui","San Francisco de Cayrán","San Pablo de Pillao","San Pedro de Chaulán","Santa María del Valle","Yurimayo","Yacus");
var opt_Huamalíes = new Array ("Seleccione el Distrito","Arancay","Chavín de Pariarca","Jacas Grande","Jircan","Llata","Miraflores","Monzón","Punchao","Puños","Singa","Tantamayo");
var opt_Leoncio_Prado = new Array ("Seleccione el Distrito","Castillo Grande","Danie Alomía Robles ","Hermilio Valdizán","José Crespo y Castillo","Luyando","Mariano Dámaso Beraún","Pucayacu","Pueblo Nuevo","Rupa-Rupa","Santo Domingo de Anda");
var opt_Marañón = new Array ("Seleccione el Distrito","Cholón","Huacrachuco","La Morada","San Buenaventura","Santa Rosa de Alto Yanajanca");
var opt_Pachitea = new Array ("Seleccione el Distrito","Chaglla","Molino","Panao","Umari");
var opt_Puerto_Inca = new Array ("Seleccione el Distrito","Codo del Pozuzo","Honoria","Puerto Inca","Tournavista","Yayapichis");
var opt_Lauricocha = new Array ("Seleccione el Distrito","Baños","Jesús","Jivia","Queropalca","Rondos","San Francisco de Asís","San Miguel de Cauri");
var opt_Yarowilca = new Array ("Seleccione el Distrito","Aparicio Pomares","Cahuac","Chacabamba","Chavinillo","Choras","Jacas Chico","Obas","Pampamarca");

var opt_Chincha = new Array ("Seleccione el Distrito","Alto Larán","Chavín","Chincha Alta","Chincha Baja","El Carmen","Grocio Prado","Pueblo Nuevo","San Juan de Yanac","San Pedro de Huacarpana","Sunampe","Tambo de Mora");
var opt_Ica = new Array ("Seleccione el Distrito","Ica","La Tinguiña","Los Aquijes","Ocucaje","Pachacútec","Parcona","Pueblo Nuevo","Salas","San José de los Molinos","San Juan Bautista","Santiago","Subtanjalla","Tate","Yauca del Rosario");
var opt_Nazca = new Array ("Seleccione el Distrito","Changuillo","El Ingenio","Marcona","Nazca","Vista Elegre");
var opt_Palpa = new Array ("Seleccione el Distrito","Llipata","Palpa","Río Grande","Santa Cruz","Tibillo");
var opt_Pisco = new Array ("Seleccione el Distrito","Huancano","Huay","Independencia","Paracas","Pisco","San Andrés","San Clemente","Túpac Amaru Inca");

var opt_Concepción = new Array ("Seleccione el Distrito","Aco","Andamarca","Chambara","Cochas","Comas","Concepción","Heroínas Toledo","Manzanares","Mariscal Castilla","Matahuasi","Mito","Nueve de Julio","Orcotuna","San José de Quero","Santa Rosa de Ocopa");
var opt_Chanchamayo = new Array ("Seleccione el Distrito","La Merced","San Luis","Perené","Pichanaqui","San Ramón","Vítoc");
var opt_Chupaca = new Array ("Seleccione el Distrito","Áhuac","Chongos Bajo","Chupaca","Huáchac","Huamancaca Chico","San Juan de Yscos","San Juan de Jarpa","Tres de Diciembre","Yanacancha");
var opt_Huancayo = new Array ("Seleccione el Distrito","Carhuacallanga","Chacapampa","Chicche","Chilca","Chongos Alto","Chupuro","Colca","Cullhuas","El Tambo","Huancayo","Huacrapuquio","Hualhuas","Huancán","Huasicancha","Huayucachi","Ingenio","Pariahuanca","Pilcomayo","Pucará","Quichuay","Quilcas","San Agustín de Cajas","San Jerónimo de Tunán","San Pedro de Saño","Santo Domingo de Acobamba","Sapallanga","Sicaya","Viques");
var opt_Jauja = new Array ("Seleccione el Distrito","Acolla","Apata","Ataura","Canchayllo","Curicaca","El Mantaro","Huamalí","Huaripampa","Huertas","Janjaillo","Jauja","Julcán","Leonor Ordóñez","Llocllapampa","Marco","Masma","Masma Chicche","Molinos","Monobamba","Muqui","Muquiyauyo","Paca","Paccha","Pancán","Parco","Pomacancha","Ricrán","San Lorenzo","San Pedro de Chunán","Sausa","Sincos","Tunanmarca","Yauli","Yauyos");
var opt_Junín = new Array ("Seleccione el Distrito","Carhuamayo","Ondores","Junín","Ulcumayo");
var opt_Satipo = new Array ("Seleccione el Distrito","Covirialí","Llaylla","Mazamari","Pampa Hermosa","Pangoa","Río Negro","Río Tambo","Satipo","Vizcatán del Ene");
var opt_Tarma = new Array ("Seleccione el Distrito","Acobamba","Huaricolca","Huasahuasi","La Unión","Palca","Palcamayo","San Pedro de Cajas","Tapo","Tarma");
var opt_Yauli = new Array ("Seleccione el Distrito","Chacapalta","Huayhuay","La Oroya","Marcapomacocha","Morococha","Paccha","Santa Barbara de Carhuacayán","Santa Rosa de Sacco","Suitucancha","Yauli");

var opt_Ascope = new Array ("Seleccione el Distrito","Ascope","Casa Grande","Chicama","Chocope","Magdalena de Cao","Paiján","Rázuri","Santiago de Cao");
var opt_Bolívar = new Array ("Seleccione el Distrito","Bolívar","Bambamarca","Condormarca","Longotea","Uchumarca","Ucuncha");
var opt_Chepén = new Array ("Seleccione el Distrito","Chepén","Pacanga","Pueblo Nuevo");
var opt_Julcán = new Array ("Seleccione el Distrito","Calamarca","Carabamba","Huaso","Julcán");
var opt_Gran_Chimú = new Array ("Seleccione el Distrito","Cascas","Lucma","Marmot","Sayapullo");
var opt_Otuzco = new Array ("Seleccione el Distrito","Agallpampa","Charat","Huaranchal","La Cuesta","Mache","Otuzco","Paranday","Salpo","Sinsicap","Usquil");
var opt_Pacasmayo = new Array ("Seleccione el Distrito","Guadalupe","Jequetepeque","Pacasmayo","San José","San Pedro de Lloc");
var opt_Pataz = new Array ("Seleccione el Distrito","Buldibuyo","Chilia","Huancaspata","Huaylillas","Huayo","Ongón","Parcoy","Pataz","Pías","Santiago de Challas","Taurija","Tayabamba","Urpay");
var opt_Sánchez_Carrión = new Array ("Seleccione el Distrito","Chugay","Cochorco","Curgos","Huamachuco","Marcabal","Sanagorán","Sarín","Sartimbamba");
var opt_Santiago_de_Chuco = new Array ("Seleccione el Distrito","Angasmarca","Cachicadán","Mollebamba","Mollepata","Quiruvilca","Santa Cruz de Chuca","Santiago de Chuco","Sitabamba");
var opt_Trujillo = new Array ("Seleccione el Distrito","El Porvenir","Florencia de Mora","Huanchaco","La Esperanza","Laredo","Moche","Poroto","Salaverry","Simbal","Trujillo","Víctor Larco Herrera");
var opt_Virú = new Array ("Seleccione el Distrito","Chao","Guadalupito","Virú");

var opt_Chiclayo= new Array ("Seleccione el Distrito","Cayaltí","Chiclayo","Chongoyape","Eten","Puerto Eten","José Leonardo Ortiz","La Victoria","Lagunas","Monsefú","Nueva Arica","Oyotún","Pátapo","Picsi","Pimentel","Pomalca","Pucalá","Reque","Santa Rosa","Tumán","Zaña");
var opt_Ferreñafe= new Array ("Seleccione el Distrito","Cañaris","Ferreñafe","Incahuasi","Manuel Antonio Mesones Muro","Pítipo","Pueblo Nuevo");
var opt_Lambayeque= new Array ("Seleccione el Distrito","Chóchope","Íllimo","Jayanca","Lambayeque","Mochumí","Mórrope","Motupe","Olmos","Pacora","Salas","San José","Túcume");

var opt_Barranca= new Array ("Seleccione el Distrito","Barranca","Paramonga","Pativilca","Supe","Supe Puerto");
var opt_Cajatambo= new Array ("Seleccione el Distrito","Gorgor","Huancapón","Cajatambo","Copa","Manás");
var opt_Canta= new Array ("Seleccione el Distrito","Arahuay","Canta","Huamantanga","Huaros","Lachaqui","San Buenaventura","Santa Rosa de Quives");
var opt_Cañete= new Array ("Seleccione el Distrito","Asia","Calango","Cerro Azul","Chilca","Coayllo","Imperial","Lunahuaná","Mala","Nuevo Imperial","Pacarán","Quilmaná","San Antonio","San Luis","San Vicente de Cañete","Santa Cruz de Flores","Zúñiga");
var opt_Huaral= new Array ("Seleccione el Distrito","Atavillos Alto","Atavillo","Aucallama","Chancay","Huaral","Ihuarí","Lampían","Pacaraos","Santa Cruz de Andama","Sumbilca","San Miguel de Acos","Veintisiete de noviembre");
var opt_Huarochirí= new Array ("Seleccione el Distrito","Antioquía","Callahuanca","Carampoma","Chicla","Cuenca","Huachupampa","Huanza","Huarochirí","Lahuaytambo","Langa","Laraos","Mariatana","Matucana","Ricardo Palma","San Andrés de Tupicocha","San Antonio","San Bartolomé","San Damián","San Juan de Iris","San Juan de Tantaranche","San Lorenzo de Quinti","San Mateo","San Mateo de Otao","San Pedro de Casta","San Pedro de Huancayre","Sangallaya","Santa Cruz de Cocachacra","Santa Eulalia","Santiago de Anchucaya","Santiago de Tuna","Santo Domingo de los Olleros","San Jerónimo de Surco");
var opt_Huaura= new Array ("Seleccione el Distrito","Ámbar","Caleta De Carquín","Checras","Huacho","Hualmay","Huaura","Leoncio Prado","Paccho","Santa Leonor","Santa María","Sayán","Vegueta");
var opt_Lima= new Array ("Seleccione el Distrito","Ancón","Ate","Barranco","Braña","Carabayllo","Chaclacayo","Chorrillos","Cieneguilla","Comas","El Agustino","Independencia","Sesús María","La Molina","La Victoría","Lima","Lince","Los Olivos","Lurigancho-Chosica","Lurin","Magdalena de Mar","Miraflores","Pueblo Libre","Pachacámac","Pucusana","Puente Piedra","Punta Hermosa","Punta Negra","Rímac","San Bartolo","San Borja","San Isidro","San Juan de Lurigancho","San Juan de Miraflores","San Luis","San Martín de Porres","San Miguel","Santa Anita","Santa María del Mar","Santa Rosa","Santiago de Surco","Surquillo","Villa el salvador","Villa María del Triunfo");
var opt_Oyón= new Array ("Seleccione el Distrito","Andajes","Caujul","Cochamarca","Naván","Oyón","Pachangara");
var opt_Yauyos= new Array ("Seleccione el Distrito","Alis","Ayauca","Ayavirí","Azángaro","Cacra","Carania","Catahuasi","Chocos","Cochas","Colonia","Hongos","Huampara","Huancaya","Huangáscar","Huantán","Huañec","Laraos","Lincha","Madean","Miraflores","Omas","Quinches","Quinocay","San Lorenzo de Putinza","San Joaquin","San Pedro de Pilas","Tanta","Tauripampa","Tomas","Tupe","Viñac","Vitis","Yauyos");

var opt_Alto_Amazonas= new Array ("Seleccione el Distrito","Balsapuerto","Jaberos","Lagunas","Santa Cruz","Teniente César López Rojas","Yurimaguas");
var opt_Datem_del_Marañón= new Array ("Seleccione el Distrito","Barranca","Cahuapanas","Manseriche","Morona","Pastaza","Andoas");
var opt_Loreto= new Array ("Seleccione el Distrito","Nauta","Parinari","Tigre","Trompeteros","Urarinas");
var opt_Maynas= new Array ("Seleccione el Distrito","Alto Nanay","Fernando Lores","Indiana","Iquitos","Las Amazonas","Mazán","Napo","Punchana","Torres Causana","Belén","San Juan Bautista");
var opt_Mariscal_Ramón_Castilla= new Array ("Seleccione el Distrito","Pebas","Ramón Castilla","San Pablo","Yavarí");
var opt_Putumayo= new Array ("Seleccione el Distrito","Putumayo","Rosa Panduro","Yaguas","Teniente Manuel Clavero");
var opt_Requena= new Array ("Seleccione el Distrito","Alto Tapiche","Capelo","Emilio San Martín","Maquía","Puinahua","Requena","Saquena","Soplin","Tapiche","Jenaro Herrera","Yaquerana");
var opt_Ucayali= new Array ("Seleccione el Distrito","Contamana","Inahuaya","Padre Márquez","Pampa Hermosa","Sarayacu","Alfredo Vargas Guerra");

var opt_Manu= new Array ("Seleccione el Distrito","Fitzcarrald","Madre de Dios","Manu","Huepetuhe");
var opt_Tambopata= new Array ("Seleccione el Distrito","Inambari","Las Piedras","Laberinto","Tambopata");
var opt_Tahuamanu= new Array ("Seleccione el Distrito","Iberia","Iñapari","Tahuamanu");

var opt_General_Sánchez_Cerro= new Array ("Seleccione el Distrito","Chojata","Coalaque","Ichuña","La Capilla","Lloque","Matalaque","Omate","Puquina","Quinistaquillas","Ubinas","Yunga");
var opt_Ilo= new Array ("Seleccione el Distrito","El Algarrobal","Ilo","Pacocha");
var opt_Mariscal_Nieto= new Array ("Seleccione el Distrito","Carumas","Cuchumbaya","Moquegua","Samegua","San Cristóbal de Calacoa","Torata");

var opt_Daniel_Alcides_Carrión= new Array ("Seleccione el Distrito","Chacatán","Goyllarisquizga","Paucar","San Pedro de Pillao","Santa Ana de Tusi","Tapuc","Vilvabamba","Yanahuanca");
var opt_Oxapampa= new Array ("Seleccione el Distrito","Chontabamba","Constitución","Huancabamba","Oxapampa","Palcazu","Pozuzo","Puerto Bermúdez","Villa Rica");
var opt_Pasco= new Array ("Seleccione el Distrito","Chaupimarca","Huachón","Huariaca","Huayllay","Ninacaca","Pallanchacra","Paucartambo","San Francisco de Asis de Yarusyacán","Simón Bolívar","Ticlacayán","Tinyahuarco","Vicco","Yanacancha");

var opt_Ayabaca= new Array ("Seleccione el Distrito","Ayabaca","Frías","Jililí","Lagunas","Montero","Pacaipampa","Paimas","Sapillica","Sincchez","Suyo");
var opt_Huancabamba= new Array ("Seleccione el Distrito","Canchaque","El Carmen de la Frontera","Huancabamba","Huarmaca","Lalaquiz","San Miguel de El Faique","Sóndor","Sondorillo");
var opt_Morropón= new Array ("Seleccione el Distrito","Buenos Aires","Chalaco","Chulucanas","La Matanza","Morropón","Salitral","San Juan de Bigote","Santa Catalina de Mossa","Santo Domngo","Yamango");
var opt_Paita= new Array ("Seleccione el Distrito","Amotape","Colán","El Arenal","La Huaca","Paita","Tamarindo","Vichayal");
var opt_Piura= new Array ("Seleccione el Distrito","Castilla","Catacaos","Cura Mori","El Tallán","La Arena","La unión","Las Lomas","Piura","Tambogrande","26 de Octubre");
var opt_Sechura= new Array ("Seleccione el Distrito","Bellavista de la Unión","Bernal","Cristo nos Valga","Rinconada-Llicuar","Sechura","Vice");
var opt_Sullana= new Array ("Seleccione el Distrito","Bellavista","Marcavelica","Salitral","Sullana","Querecotillo","Lancones","Ignacion Esdudero","Miguel Checa");
var opt_Talara= new Array ("Seleccione el Distrito","El Alto","La Brea","Lobitos","Los Órganos","Máncora","Pirañas");

var opt_Azángaro= new Array ("Seleccione el Distrito","Achaya","Arapa","Asilo","Azángaro","Caminaca","Chupa","José Domingo Choquehuanca","Muñani","Potoni","Samán","San Antón","San José","San Juan de Salinas","Santiago de Pupuja","Tirapata");
var opt_Carabaya= new Array ("Seleccione el Distrito","Ajoyani","Ayapata","Coasa","Corani","Crucero","Ituata","Macusani","Ollachea","San Gabán","Usicayos");
var opt_Chucuito= new Array ("Seleccione el Distrito","Desaguadero","Huacullani","Juli","Kelluyo","Pisacoma","Pomata","Zepita");
var opt_El_Collao= new Array ("Seleccione el Distrito","Capaso","Conduriri","Ilave","Pilcuyo","Santa Rosa");
var opt_Huancané= new Array ("Seleccione el Distrito","Huancané","Pusi","Vilque Chico","Taraco","Huatasani");
var opt_Lampa= new Array ("Seleccione el Distrito","Cabanilla","Calapuja","Lampa","Nicasio","Ocuviri","Palca","Paratía","Pucará","Santa Lucía","Vilavila");
var opt_Melgar= new Array ("Seleccione el Distrito","Antauta","Ayaviri","Cupi","Llalli","Macari","Ñuñoa","Orurillo","Santa Rosa","Umachiri");
var opt_Moho= new Array ("Seleccione el Distrito","Conima","Huayrapata","Moho","Tilali");
var opt_Puno= new Array ("Seleccione el Distrito","Ácora","Amantaní","Atuncolla","Capachica","Chucuito","Coata","Huata","Mañazo","Paucarcolla","Pichacani","Platería","Puno","San Antonio","Tiquillaca","Vilque");
var opt_San_Antonio_de_Putina= new Array ("Seleccione el Distrito","Ananea","Pedro Vilca Apaza","Putina","Quilcapuncu","Sina");
var opt_San_Román= new Array ("Seleccione el Distrito","Cabana","Cabanillas","Caracoto","Juliaca","San Miguel");
var opt_Sandia= new Array ("Seleccione el Distrito","Alto Inambari","Cuyocuyo","Limbani","Patamburco","Phara","Quiaca","San Juan del Oro","San Pedro de Putinapunco","Sandia","Yanahuaya");
var opt_Yunguyo= new Array ("Seleccione el Distrito","Anapia","Copani","Cuturapi","Ollaraya","Tinacachi","Unicachi","Yunguyo");

var opt_Bellavista= new Array ("Seleccione el Distrito","Alto Biavo","Bajo Biavo","Bellavista","Huallaga","San Pablo","San Rafael");
var opt_El_Dorado= new Array ("Seleccione el Distrito","Agua Blanca","San José de Sisa","San Martín","Santa Rosa","Shatoja");
var opt_Huallaga= new Array ("Seleccione el Distrito","Alto Saposoa","El Eslabón","Piscoyacu","Sacanche","Saposoa","Tingo de Saposoa");
var opt_Lamas= new Array ("Seleccione el Distrito","Alonso de Alvarado","Barranquita","Caynarachi","Cuñunbuqui","Lamas","Pinto Recodo","Rumisapa","San Roque de Cumbaza","Shanao","Tabalosos","Zapatero");
var opt_Mariscal_Cáceres= new Array ("Seleccione el Distrito","Campanilla","Costa Rica","Dos de Mayo","Huicungo","Juanjuí","Juanjuicillo","La Merced","Pachiza","Pajarillo");
var opt_Moyobamba= new Array ("Seleccione el Distrito","Calzada","Habana","Jepelacio","Moyobamba","Soritor","Yantalo");
var opt_Picota= new Array ("Seleccione el Distrito","Buenos Aires","Caspizapa","Picota","Pilluana","Pucacaca","San Cristónal","San Hilarion","Shamboyacu","Tingo se Ponanza","Tres Unidos");
var opt_Rioja= new Array ("Seleccione el Distrito","Awajún","Elias Soplin Vargas","Nueva Cajamarca","Pardo Miguel","Posic","Rioja","San Fernando","Yorongos","Yuracyacu");
var opt_San_Martín= new Array ("Seleccione el Distrito","Alberto Leveau","Cacatachi","Chazuta","Chipurana","El Porvenir","Huimbayoc","Juan Guerra","La Banda de Shilcayo","Morales","Papaplaya","San Antonio","Sauce","Shapaja","Tarapoto");
var opt_Tocache= new Array ("Seleccione el Distrito","Nuevo Progreso","Pólvora","Shunte","Tocache","Uchiza");

var opt_Candarave= new Array ("Seleccione el Distrito","Cairari","Camilaca","Candarave","Curibaya","Huanuara","Quilahuani");
var opt_Jorge_Basadre= new Array ("Seleccione el Distrito","Ilabaya","Ite","Locumba");
var opt_Tacna= new Array ("Seleccione el Distrito","Alto de la Alianza","Calana","Ciudad Nueva","Coronel Gregorio Albarracín Lanchipa","Inclán","La Yarada-Los Palos","Pachía","Palca","Pocollay","Sama","Tacna");
var opt_Tarata= new Array ("Seleccione el Distrito","Estique","Estique Pampa","Heróes Albarracín","Sitajara","Susapaya","Tarata","Tarucachi","Ticaco");

var opt_Contralmirante_Villar= new Array ("Seleccione el Distrito","Canoas de Punta Sal","Casitas","Zorritos");
var opt_Tumbes= new Array ("Seleccione el Distrito","Corrales","La Cruz","Pampas de Hospital","San Jacinto","San Juan de la Virgen","Tumbes");
var opt_Zarumilla= new Array ("Seleccione el Distrito","Aguas Verdes","Matapalo","Papayal","Zarumilla");

var opt_Atalaya= new Array ("Seleccione el Distrito","Raimondi","Sepahua","Tahuanía","Yurúa");
var opt_Coronel_Portillo= new Array ("Seleccione el Distrito","Callería","Campoverde","Iparía","Masisea","Yarinacocha","Nueva Requena","Manantay");
var opt_Padre_Abad= new Array ("Seleccione el Distrito","Alexander von Humboldt","Curimaná","Irázola","Neshuya","Padre Abad");
var opt_Purús= new Array ("Seleccione el Distrito","Purús");

//Funciones para el input de los documenbtos
function mostrarCheck_inputdocumento(input, checkSelector) {
    if ($(input).prop("files").length > 0) {
        $(checkSelector).show();  // Mostrar check
    } else {
        $(checkSelector).hide();  // Ocultar check
    }
}

function borrarArchivo_inputdocumento(inputSelector, checkSelector) {
    $(inputSelector).val("");   // Limpia archivo
    $(checkSelector).hide();    // Oculta check
}

function validarDocumentos() {
    let valido = true;
    let mensaje = "<div style='text-align:left;'>";

    $("input[type='file']:visible").each(function () {
        if (!this.files || this.files.length === 0) {
            let label = $(this).closest(".card-body").find("label").text();
            mensaje += `<div>❌ Falta adjuntar: <strong>${label}</strong></div>`;
            valido = false;
        }
    });

    mensaje += "</div>";

    if (!valido) {
        // Enviamos mensaje como HTML
        respuesta(mensaje, "error", 6000, true);
    }

    return valido;
}
//*

function onchange_selectTipoPersona(valor) {
    if(valor === "1"){
        $("#idspan_documentos").text("(Ficha RUC, Copia del DNI y  Ficha de inscripción firmada.)");

        // Cambiar solo el texto, no el span del check
        $("#idlabel_ficharuc").contents().first().replaceWith("Ficha RUC ");
        $("#idlabel_DNI").contents().first().replaceWith("Copia del DNI ");
        $("#idlabel_fichainscripcion").contents().first().replaceWith("Ficha de inscripción firmada ");

        // Ocultar algunos grupos
        $("#idgrupo_vigenciapoder").hide();
        $("#idgrupo_partidaregistraoempresa").hide();
        $("#idgrupo_reportetercerossunat").hide();
        $("#idgrupo_comprobantederechoafiliacion").hide();
    }
    else {
        $("#idspan_documentos").text("(Ficha RUC, Copia del DNI del representante legal, Ficha de inscripción firmada por el representante legal, etc.)");

        $("#idlabel_ficharuc").contents().first().replaceWith("Ficha RUC ");
        $("#idlabel_DNI").contents().first().replaceWith("Copia del DNI del representante legal ");
        $("#idlabel_fichainscripcion").contents().first().replaceWith("Ficha de inscripción firmada por el representante legal ");

        $("#idgrupo_vigenciapoder").show();
        $("#idgrupo_partidaregistraoempresa").show();
        $("#idgrupo_reportetercerossunat").show();
        $("#idgrupo_comprobantederechoafiliacion").show();
    }
}


function cambiaDistrito() {
    var cosa;
    selectProvincia = document.getElementById('selectProvincia').value;

    if(selectProvincia!=0)
    {
        mis_opts=eval("opt_" + selectProvincia);
        num_opts=mis_opts.length;

        document.getElementById('selectDistrito').length = num_opts;

        for(i=0; i<num_opts; i++)
        {
            document.getElementById('selectDistrito').options[0].value="";
            document.getElementById('selectDistrito').options[0].text="Seleccione el Distrito";

            document.getElementById('selectDistrito').options[i].value=mis_opts[i];
            document.getElementById('selectDistrito').options[i].text=mis_opts[i];
        }
    }
    else
    {
        document.getElementById('selectDistrito').length = 1;
        document.getElementById('selectDistrito').options[0].value="-";
        document.getElementById('selectDistrito').options[0].text="-";
    }
    document.getElementById('selectDistrito').options[0].selected = true;
}

function rubro_x_sector(){
    var select = $("#id_rubro");
    select.empty();
    var id_sector = $("#id_sector").val();
    if(id_sector!==""){
        $.ajax({
            type: "POST",
            url: urlweb + "api/Socios/rubro_por_sector",
            data: "id_sector=" + id_sector,
            dataType: 'json',
            success:function (r) {                select.append('<option value=""> Seleccione </option>');
                r.forEach(function(item) {
                    select.append('<option value="' + item.id_rubro + '">' + item.rubro_nombre + '</option>');
                });
            }
        });
    }
}

function listarcategoriaselectapi(parametros) {
    var select = $("#idselect_categoriaafiliado");
    select.empty();

    $.ajax({
        type: "POST",
        url: urlweb + `api/Categorias/listar_categoria_select/`,
        dataType: 'json',
        success: function (r) {
            select.append('<option value="">Seleccione</option>');

            r.forEach(function(item) {
                select.append(
                    `<option value="${item.id_categoria}" 
                        data-cuota="${item.categoria_cuota}"
                        data-cuota-anual="${item.categoria_cuota_anual}"
                        data-estado="${item.categoria_estado}"
                        data-horas-auditorio="${item.categoria_horas_auditorio}"
                        data-inscripcion="${item.categoria_inscripcion}"
                        data-usuario="${item.categoria_usuario}"
                        data-cant="${item.categoriabeneficio_cant}"
                        data-tipocant="${item.tipobenificios_nombre}">
                        ${item.categoria_nombre}
                    </option>`
                );
            });

            // 👇 aquí recién seteas el valor cuando ya se cargó
            if (parametros) {
                $("#idselect_categoriaafiliado").val(parametros.socio_id_categoria);
            }
        }
    });
}


function editar_vista_socio(parametros){
    $("#id_cliente").val(parametros.socio_id_cliente);
    $("#empresa_tipo").val(parametros.cliente_tipopersona);
    $("#empresa_ruc").val(parametros.cliente_numero);
    $("#empresa_razonsocial").val(parametros.cliente_razonsocial);
    $("#empresa_nombre").val(parametros.socio_nombre_comercial);
    $("#selectDepartamento").val(parametros.socio_departamento);
    $("#selectProvincia").val(parametros.socio_provincia);
    $("#selectDistrito").val(parametros.socio_distrito);
    $("#empresa_direccion").val(parametros.cliente_direccion);
    $("#empresa_fundacion").val(parametros.socio_fecha_fundacion);
    $("#id_sector").val(parametros.socio_sector);
    $("#id_rubro").val(parametros.socio_rubro);
    $("#empresa_descripcion1").val(parametros.socio_descripcion_actividad);
    $("#empresa_telefono1").val(parametros.cliente_telefono1);
    $("#empresa_telefono2").val(parametros.cliente_telefono2);
    $("#empresa_celular1").val(parametros.cliente_celular1);
    $("#empresa_celular2").val(parametros.cliente_celular2);

    $("#empresa_paginaweb").val(parametros.socio_pagina_web);
    $("#empresa_email").val(parametros.cliente_correo);
    $("#empresa_apellidos").val(parametros.socio_nombre_ejecutivo);
    $("#idinputcargoafiliado").val(parametros.socio_cargo_ejecutivo);

    $("#idinput_ornomasticoafiliado").val(parametros.socio_ornomastico);
    $("#idinput_emailejecutivo").val(parametros.socio_email_ejecutivo);

    //Actividades faltaria
    $("#idselect_categoriaafiliado").val(parametros.socio_id_categoria);
    $("#idinputcuotamensualafiliacion").val(parametros.categoria_cuota);
    $("#idselecttipopago").val(parametros.socio_tipo_pago);



}

function guardarsocio(formulario) {
    if (!validarDocumentos()) return;

    let formData = new FormData();

    // Pasamos todos los campos serializados
    formulario.forEach(function (item) {
        formData.append(item.name, item.value);
    });

    // Agrega extras
    formData.append("socio_estado", 1);
    formData.append("socio_creacion", fechaLocal);

    // archivo PDF
    let archivoidinputRUC = document.getElementById("idinputRUC").files[0];
    let archivoidinputDNI= document.getElementById("idinputDNI").files[0];
    let archivologoempresa= document.getElementById("inputlogoempresa").files[0];
    let archivoidinput_fichainscripcionfirmada = document.getElementById("idinput_fichainscripcionfirmada").files[0];

    if(archivoidinputRUC && archivoidinputDNI && archivoidinput_fichainscripcionfirmada && archivologoempresa){
        formData.append("archivoidinputRUC", archivoidinputRUC);
        formData.append("archivoidinputDNI", archivoidinputDNI);
        formData.append("archivologoempresa", archivologoempresa);
        formData.append("archivoidinput_fichainscripcionfirmada", archivoidinput_fichainscripcionfirmada);
    }

    if($("#empresa_tipo").val() === "2"){
        let archivoidinput_vigenciapoder = document.getElementById("idinput_vigenciapoder").files[0];
        let archivoidinput_partidaregistraoempresa = document.getElementById("idinput_partidaregistraoempresa").files[0];
        let archivoidinput_reportetercerossunat = document.getElementById("idinput_reportetercerossunat").files[0];
        let archivoidinput_comprobantederechoafiliacion = document.getElementById("idinput_comprobantederechoafiliacion").files[0];

        if(archivoidinput_vigenciapoder
            && archivoidinput_partidaregistraoempresa
            && archivoidinput_reportetercerossunat
            && archivoidinput_comprobantederechoafiliacion){
            formData.append("archivoidinput_vigenciapoder", archivoidinput_vigenciapoder);
            formData.append("archivoidinput_partidaregistraoempresa", archivoidinput_partidaregistraoempresa);
            formData.append("archivoidinput_reportetercerossunat", archivoidinput_reportetercerossunat);
            formData.append("archivoidinput_comprobantederechoafiliacion", archivoidinput_comprobantederechoafiliacion);
        }
    }

    // let archivo = document.getElementById("idinputRUC").files[0];
    // if (archivo) {
    //     formData.append("documento", archivo);
    // }
    //
    Swal.fire({
        title: 'Guardando socio...',
        text: 'Por favor espere',
        allowOutsideClick: false,
        allowEscapeKey: false,
        didOpen: () => {
            Swal.showLoading();
        }
    });

    $.ajax({
        type: "POST",
        url: urlweb + "api/Socios/guardar_socio",
        data: formData,
        contentType: false,  // 👈 necesario
        processData: false,  // 👈 necesario
        dataType: 'json',
        success: function (r) {
            Swal.close();
            respuesta(
                r.result.code === 1 ? "socio registrado correctamente" : r.result.message,
                r.result.code === 1 ? "success" : "error"
            );

            if (r.result.code === 1) {
                setTimeout(function () { location.reload(); }, 1000);
            }
        },
        error: function (xhr) {
            Swal.close();
            console.error("Error en la petición:", xhr.responseText);
        }
    });
}





function seleccionar_Cliente_tablamodalCliente_vistacrearsocio($btn){
    const cliente = JSON.parse($btn.attr('data-service'));
    $("#id_cliente").val(cliente.id_cliente);
    $("#empresa_tipo").val(cliente.cliente_tipopersona);
    $("#empresa_ruc").val(cliente.cliente_numero);
    $("#empresa_razonsocial").val(cliente.cliente_razonsocial === '' ? cliente.cliente_nombre : cliente.cliente_razonsocial);
    $("#empresa_telefono1").val(cliente.telefono1);
    $("#empresa_telefono2").val(cliente.telefono2);
    $("#empresa_celular1").val(cliente.celular1);
    $("#empresa_celular2").val(cliente.celular2);
    $("#empresa_email").val(cliente.correo);
    $("#empresa_nombre").focus();

    onchange_selectTipoPersona(cliente.cliente_tipopersona);
}

function consultar_documento_vistacrearfilicacion(valor){
    try{
        if(valor.trim() === '') {
            return;
        }

        if(valor.length !== 11){
            throw new Error("El Ruc requiere de 11 dígitos");
        }

        $.ajax({
            type: "POST",
            url: urlweb + "api/Clientes/obtener_datos_x_numdocumento",
            data: {
                numero: valor
            },
            dataType: 'json',
            success: function (r) {
                if (!r || !r.result) {
                    consultarAPIExterna_vistacrearafilicacion();
                    return;
                }

                if (!r.result.success) {
                    consultarAPIExterna_vistacrearafilicacion();
                    return;
                }


                const clienteData = r.result.data;
                if (clienteData && (clienteData.id_cliente || clienteData.cliente_numero || clienteData.cliente_nombre || clienteData.cliente_razonsocial)) {

                    let nombreCliente = clienteData.cliente_razonsocial;
                    $("#empresa_tipo").val(2);
                    onchange_selectTipoPersona($("#empresa_tipo").val());
                    $("#id_cliente").val(clienteData.id_cliente);
                    $("#empresa_razonsocial").val(nombreCliente);
                    $("#empresa_direccion").val(clienteData.cliente_direccion || '');

                    respuesta("Cliente encontrado en base de datos", "success");
                    return;
                }

                // Si llega aca, no encontró en la bd, bufrca en la api
                consultarAPIExterna_vistacrearafilicacion();
            },
            error: function(xhr, status, error) {
                console.error("Error AJAX:", error);
                respuesta("Error de conexión con base de datos", "warning");
                consultarAPIExterna_vistacrearafilicacion();
            }
        });
    }
    catch (ex){
        $("#id_cliente").val('');
        $("#empresa_razonsocial").val('');
        $("#empresa_direccion").val('');
        $("#empresa_tipo").val(2);
        respuesta(ex.toString(), "error");
    }
}

//API externa DOC
function consultarAPIExterna_vistacrearafilicacion() {
    $("#id_cliente").val("0");
    $("#empresa_tipo").val(2);
    onchange_selectTipoPersona($("#empresa_tipo").val());
    consultarNumdocumentoAPI(
        4,
        'empresa_ruc',
        'empresa_razonsocial',
        'empresa_direccion'
    );
}