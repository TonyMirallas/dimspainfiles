const countries = [
   {key: 144, "label": "Afganistán"},
   {key: 114, "label": "Albania"},
   {key: 18, "label": "Alemania"},
   {key: 98, "label": "Algeria"},
   {key: 145, "label": "Andorra"},
   {key: 119, "label": "Angola"},
   {key: 4, "label": "Anguilla"},
   {key: 147, "label": "Antigua y Barbuda"},
   {key: 207, "label": "Antillas Holandesas"},
   {key: 91, "label": "Arabia Saudita"},
   {key: 5, "label": "Argentina"},
   {key: 6, "label": "Armenia"},
   {key: 142, "label": "Aruba"},
   {key: 1, "label": "Australia"},
   {key: 2, "label": "Austria"},
   {key: 3, "label": "Azerbaiyán"},
   {key: 80, "label": "Bahamas"},
   {key: 127, "label": "Bahrein"},
   {key: 149, "label": "Bangladesh"},
   {key: 128, "label": "Barbados"},
   {key: 9, "label": "Bélgica"},
   {key: 8, "label": "Belice"},
   {key: 151, "label": "Benín"},
   {key: 10, "label": "Bermudas"},
   {key: 7, "label": "Bielorrusia"},
   {key: 123, "label": "Bolivia"},
   {key: 79, "label": "Bosnia y Herzegovina"},
   {key: 100, "label": "Botsuana"},
   {key: 12, "label": "Brasil"},
   {key: 155, "label": "Brunéi"},
   {key: 11, "label": "Bulgaria"},
   {key: 156, "label": "Burkina Faso"},
   {key: 157, "label": "Burundi"},
   {key: 152, "label": "Bután"},
   {key: 159, "label": "Cabo Verde"},
   {key: 158, "label": "Camboya"},
   {key: 31, "label": "Camerún"},
   {key: 32, "label": "Canadá"},
   {key: 130, "label": "Chad"},
   {key: 81, "label": "Chile"},
   {key: 35, "label": "China"},
   {key: 33, "label": "Chipre"},
   {key: 82, "label": "Colombia"},
   {key: 164, "label": "Comores"},
   {key: 112, "label": "Congo (Brazzaville)"},
   {key: 165, "label": "Congo (Kinshasa)"},
   {key: 166, "label": "Cook, Islas"},
   {key: 84, "label": "Corea del Norte"},
   {key: 69, "label": "Corea del Sur"},
   {key: 168, "label": "Costa de Marfil"},
   {key: 36, "label": "Costa Rica"},
   {key: 71, "label": "Croacia"},
   {key: 113, "label": "Cuba"},
   {key: 22, "label": "Dinamarca"},
   {key: 169, "label": "Djibouti, Yibuti"},
   {key: 103, "label": "Ecuador"},
   {key: 23, "label": "Egipto"},
   {key: 51, "label": "El Salvador"},
   {key: 93, "label": "Emiratos Árabes Unidos"},
   {key: 173, "label": "Eritrea"},
   {key: 52, "label": "Eslovaquia"},
   {key: 53, "label": "Eslovenia"},
   {key: 28, "label": "España"},
   {key: 55, "label": "Estados Unidos"},
   {key: 68, "label": "Estonia"},
   {key: 121, "label": "Etiopía"},
   {key: 175, "label": "Feroe, Islas"},
   {key: 90, "label": "Filipinas"},
   {key: 63, "label": "Finlandia"},
   {key: 176, "label": "Fiyi"},
   {key: 64, "label": "Francia"},
   {key: 180, "label": "Gabón"},
   {key: 181, "label": "Gambia"},
   {key: 21, "label": "Georgia"},
   {key: 105, "label": "Ghana"},
   {key: 143, "label": "Gibraltar"},
   {key: 184, "label": "Granada"},
   {key: 20, "label": "Grecia"},
   {key: 94, "label": "Groenlandia"},
   {key: 17, "label": "Guadalupe"},
   {key: 185, "label": "Guatemala"},
   {key: 186, "label": "Guernsey"},
   {key: 187, "label": "Guinea"},
   {key: 172, "label": "Guinea Ecuatorial"},
   {key: 188, "label": "Guinea-Bissau"},
   {key: 189, "label": "Guyana"},
   {key: 16, "label": "Haiti"},
   {key: 137, "label": "Honduras"},
   {key: 73, "label": "Hong Kong"},
   {key: 14, "label": "Hungría"},
   {key: 25, "label": "India"},
   {key: 74, "label": "Indonesia"},
   {key: 140, "label": "Irak"},
   {key: 26, "label": "Irán"},
   {key: 27, "label": "Irlanda"},
   {key: 215, "label": "Isla Pitcairn"},
   {key: 83, "label": "Islandia"},
   {key: 228, "label": "Islas Salomón"},
   {key: 58, "label": "Islas Turcas y Caicos"},
   {key: 154, "label": "Islas Virgenes Británicas"},
   {key: 24, "label": "Israel"},
   {key: 29, "label": "Italia"},
   {key: 132, "label": "Jamaica"},
   {key: 70, "label": "Japón"},
   {key: 193, "label": "Jersey"},
   {key: 75, "label": "Jordania"},
   {key: 30, "label": "Kazajstán"},
   {key: 97, "label": "Kenia"},
   {key: 34, "label": "Kirguistán"},
   {key: 195, "label": "Kiribati"},
   {key: 37, "label": "Kuwait"},
   {key: 196, "label": "Laos"},
   {key: 197, "label": "Lesotho"},
   {key: 38, "label": "Letonia"},
   {key: 99, "label": "Líbano"},
   {key: 198, "label": "Liberia"},
   {key: 39, "label": "Libia"},
   {key: 126, "label": "Liechtenstein"},
   {key: 40, "label": "Lituania"},
   {key: 41, "label": "Luxemburgo"},
   {key: 85, "label": "Macedonia"},
   {key: 134, "label": "Madagascar"},
   {key: 76, "label": "Malasia"},
   {key: 125, "label": "Malawi"},
   {key: 200, "label": "Maldivas"},
   {key: 133, "label": "Malí"},
   {key: 86, "label": "Malta"},
   {key: 131, "label": "Man, Isla de"},
   {key: 104, "label": "Marruecos"},
   {key: 201, "label": "Martinica"},
   {key: 202, "label": "Mauricio"},
   {key: 108, "label": "Mauritania"},
   {key: 42, "label": "México"},
   {key: 43, "label": "Moldavia"},
   {key: 44, "label": "Mónaco"},
   {key: 139, "label": "Mongolia"},
   {key: 117, "label": "Mozambique"},
   {key: 205, "label": "Myanmar"},
   {key: 102, "label": "Namibia"},
   {key: 206, "label": "Nauru"},
   {key: 107, "label": "Nepal"},
   {key: 209, "label": "Nicaragua"},
   {key: 210, "label": "Níger"},
   {key: 115, "label": "Nigeria"},
   {key: 212, "label": "Norfolk Island"},
   {key: 46, "label": "Noruega"},
   {key: 208, "label": "Nueva Caledonia"},
   {key: 45, "label": "Nueva Zelanda"},
   {key: 213, "label": "Omán"},
   {key: 19, "label": "Países Bajos, Holanda"},
   {key: 87, "label": "Pakistán"},
   {key: 124, "label": "Panamá"},
   {key: 88, "label": "Papúa-Nueva Guinea"},
   {key: 110, "label": "Paraguay"},
   {key: 89, "label": "Perú"},
   {key: 178, "label": "Polinesia Francesa"},
   {key: 47, "label": "Polonia"},
   {key: 48, "label": "Portugal"},
   {key: 246, "label": "Puerto Rico"},
   {key: 216, "label": "Qatar"},
   {key: 13, "label": "Reino Unido"},
   {key: 65, "label": "República Checa"},
   {key: 138, "label": "República Dominicana"},
   {key: 49, "label": "Reunión"},
   {key: 217, "label": "Ruanda"},
   {key: 72, "label": "Rumanía"},
   {key: 50, "label": "Rusia"},
   {key: 242, "label": "Sáhara Occidental"},
   {key: 223, "label": "Samoa"},
   {key: 219, "label": "San Cristobal y Nevis"},
   {key: 224, "label": "San Marino"},
   {key: 221, "label": "San Pedro y Miquelón"},
   {key: 225, "label": "San Tomé y Príncipe"},
   {key: 222, "label": "San Vincente y Granadinas"},
   {key: 218, "label": "Santa Elena"},
   {key: 220, "label": "Santa Lucía"},
   {key: 135, "label": "Senegal"},
   {key: 226, "label": "Serbia y Montenegro"},
   {key: 109, "label": "Seychelles"},
   {key: 227, "label": "Sierra Leona"},
   {key: 77, "label": "Singapur"},
   {key: 106, "label": "Siria"},
   {key: 229, "label": "Somalia"},
   {key: 120, "label": "Sri Lanka"},
   {key: 141, "label": "Sudáfrica"},
   {key: 232, "label": "Sudán"},
   {key: 67, "label": "Suecia"},
   {key: 66, "label": "Suiza"},
   {key: 54, "label": "Surinam"},
   {key: 234, "label": "Swazilandia"},
   {key: 56, "label": "Tadjikistan"},
   {key: 92, "label": "Tailandia"},
   {key: 78, "label": "Taiwan"},
   {key: 101, "label": "Tanzania"},
   {key: 171, "label": "Timor Oriental"},
   {key: 136, "label": "Togo"},
   {key: 235, "label": "Tokelau"},
   {key: 236, "label": "Tonga"},
   {key: 237, "label": "Trinidad y Tobago"},
   {key: 122, "label": "Túnez"},
   {key: 57, "label": "Turkmenistan"},
   {key: 59, "label": "Turquía"},
   {key: 239, "label": "Tuvalu"},
   {key: 62, "label": "Ucrania"},
   {key: 60, "label": "Uganda"},
   {key: 111, "label": "Uruguay"},
   {key: 61, "label": "Uzbekistán"},
   {key: 240, "label": "Vanuatu"},
   {key: 95, "label": "Venezuela"},
   {key: 15, "label": "Vietnam"},
   {key: 241, "label": "Wallis y Futuna"},
   {key: 243, "label": "Yemen"},
   {key: 116, "label": "Zambia"},
   {key: 96, "label": "Zimbabwe"},
]

const countriesLabel = [
   {key: 'Afganistán', "label": "Afganistán"},
   {key: 'Albania', "label": "Albania"},
   {key: 'Alemania', "label": "Alemania"},
   {key: 'Algeria', "label": "Algeria"},
   {key: 'Andorra', "label": "Andorra"},
   {key: 'Angola', "label": "Angola"},
   {key: 'Anguilla', "label": "Anguilla"},
   {key: 'Antigua y Barbuda', "label": "Antigua y Barbuda"},
   {key: 'Antillas Holandesas', "label": "Antillas Holandesas"},
   {key: 'Arabia Saudita', "label": "Arabia Saudita"},
   {key: 'Argentina', "label": "Argentina"},
   {key: 'Armenia', "label": "Armenia"},
   {key: 'Aruba', "label": "Aruba"},
   {key: 'Australia', "label": "Australia"},
   {key: 'Austria', "label": "Austria"},
   {key: 'Azerbaiyán', "label": "Azerbaiyán"},
   {key: 'Bahamas', "label": "Bahamas"},
   {key: 'Bahrein', "label": "Bahrein"},
   {key: 'Bangladesh', "label": "Bangladesh"},
   {key: 'Barbados', "label": "Barbados"},
   {key: 'Bélgica', "label": "Bélgica"},
   {key: 'Belice', "label": "Belice"},
   {key: 'Benín', "label": "Benín"},
   {key: 'Bermudas', "label": "Bermudas"},
   {key: 'Bielorrusia', "label": "Bielorrusia"},
   {key: 'Bolivia', "label": "Bolivia"},
   {key: 'Bosnia y Herzegovina', "label": "Bosnia y Herzegovina"},
   {key: 'Botsuana', "label": "Botsuana"},
   {key: 'Brasil', "label": "Brasil"},
   {key: 'Brunéi', "label": "Brunéi"},
   {key: 'Bulgaria', "label": "Bulgaria"},
   {key: 'Burkina Faso', "label": "Burkina Faso"},
   {key: 'Burundi', "label": "Burundi"},
   {key: 'Bután', "label": "Bután"},
   {key: 'Cabo Verde', "label": "Cabo Verde"},
   {key: 'Camboya', "label": "Camboya"},
   {key: 'Camerún', "label": "Camerún"},
   {key: 'Canadá', "label": "Canadá"},
   {key: 'Chad', "label": "Chad"},
   {key: 'Chile', "label": "Chile"},
   {key: 'China', "label": "China"},
   {key: 'Chipre', "label": "Chipre"},
   {key: 'Colombia', "label": "Colombia"},
   {key: 'Comores', "label": "Comores"},
   {key: 'Congo (Brazzaville)', "label": "Congo (Brazzaville)"},
   {key: 'Congo (Kinshasa)', "label": "Congo (Kinshasa)"},
   {key: 'Cook, Islas', "label": "Cook, Islas"},
   {key: 'Corea del Norte', "label": "Corea del Norte"},
   {key: 'Corea del Sur', "label": "Corea del Sur"},
   {key: 'Costa de Marfil', "label": "Costa de Marfil"},
   {key: 'Costa Rica', "label": "Costa Rica"},
   {key: 'Croacia', "label": "Croacia"},
   {key: 'Cuba', "label": "Cuba"},
   {key: 'Dinamarca', "label": "Dinamarca"},
   {key: 'Djibouti, Yibuti', "label": "Djibouti, Yibuti"},
   {key: 'Ecuador', "label": "Ecuador"},
   {key: 'Egipto', "label": "Egipto"},
   {key: 'El Salvador', "label": "El Salvador"},
   {key: 'Emiratos Árabes Unidos', "label": "Emiratos Árabes Unidos"},
   {key: 'Eritrea', "label": "Eritrea"},
   {key: 'Eslovaquia', "label": "Eslovaquia"},
   {key: 'Eslovenia', "label": "Eslovenia"},
   {key: 'España', "label": "España"},
   {key: 'Estados Unidos', "label": "Estados Unidos"},
   {key: 'Estonia', "label": "Estonia"},
   {key: 'Etiopía', "label": "Etiopía"},
   {key: 'Feroe, Islas', "label": "Feroe, Islas"},
   {key: 'Filipinas', "label": "Filipinas"},
   {key: 'Finlandia', "label": "Finlandia"},
   {key: 'Fiyi', "label": "Fiyi"},
   {key: 'Francia', "label": "Francia"},
   {key: 'Gabón', "label": "Gabón"},
   {key: 'Gambia', "label": "Gambia"},
   {key: 'Georgia', "label": "Georgia"},
   {key: 'Ghana', "label": "Ghana"},
   {key: 'Gibraltar', "label": "Gibraltar"},
   {key: 'Granada', "label": "Granada"},
   {key: 'Grecia', "label": "Grecia"},
   {key: 'Groenlandia', "label": "Groenlandia"},
   {key: 'Guadalupe', "label": "Guadalupe"},
   {key: 'Guatemala', "label": "Guatemala"},
   {key: 'Guernsey', "label": "Guernsey"},
   {key: 'Guinea', "label": "Guinea"},
   {key: 'Guinea Ecuatorial', "label": "Guinea Ecuatorial"},
   {key: 'Guinea-Bissau', "label": "Guinea-Bissau"},
   {key: 'Guyana', "label": "Guyana"},
   {key: 'Haiti', "label": "Haiti"},
   {key: 'Honduras', "label": "Honduras"},
   {key: 'Hong Kong', "label": "Hong Kong"},
   {key: 'Hungría', "label": "Hungría"},
   {key: 'India', "label": "India"},
   {key: 'Indonesia', "label": "Indonesia"},
   {key: 'Irak', "label": "Irak"},
   {key: 'Irán', "label": "Irán"},
   {key: 'Irlanda', "label": "Irlanda"},
   {key: 'Isla Pitcairn', "label": "Isla Pitcairn"},
   {key: 'Islandia', "label": "Islandia"},
   {key: 'Islas Salomón', "label": "Islas Salomón"},
   {key: 'Islas Turcas y Caicos', "label": "Islas Turcas y Caicos"},
   {key: 'Islas Virgenes Británicas', "label": "Islas Virgenes Británicas"},
   {key: 'Israel', "label": "Israel"},
   {key: 'Italia', "label": "Italia"},
   {key: 'Jamaica', "label": "Jamaica"},
   {key: 'Japón', "label": "Japón"},
   {key: 'Jersey', "label": "Jersey"},
   {key: 'Jordania', "label": "Jordania"},
   {key: 'Kazajstán', "label": "Kazajstán"},
   {key: 'Kenia', "label": "Kenia"},
   {key: 'Kirguistán', "label": "Kirguistán"},
   {key: 'Kiribati', "label": "Kiribati"},
   {key: 'Kuwait', "label": "Kuwait"},
   {key: 'Laos', "label": "Laos"},
   {key: 'Lesotho', "label": "Lesotho"},
   {key: 'Letonia', "label": "Letonia"},
   {key: 'Líbano', "label": "Líbano"},
   {key: 'Liberia', "label": "Liberia"},
   {key: 'Libia', "label": "Libia"},
   {key: 'Liechtenstein', "label": "Liechtenstein"},
   {key: 'Lituania', "label": "Lituania"},
   {key: 'Luxemburgo', "label": "Luxemburgo"},
   {key: 'Macedonia', "label": "Macedonia"},
   {key: 'Madagascar', "label": "Madagascar"},
   {key: 'Malasia', "label": "Malasia"},
   {key: 'Malawi', "label": "Malawi"},
   {key: 'Maldivas', "label": "Maldivas"},
   {key: 'Malí', "label": "Malí"},
   {key: 'Malta', "label": "Malta"},
   {key: 'Man, Isla de', "label": "Man, Isla de"},
   {key: 'Marruecos', "label": "Marruecos"},
   {key: 'Martinica', "label": "Martinica"},
   {key: 'Mauricio', "label": "Mauricio"},
   {key: 'Mauritania', "label": "Mauritania"},
   {key: 'México', "label": "México"},
   {key: 'Moldavia', "label": "Moldavia"},
   {key: 'Mónaco', "label": "Mónaco"},
   {key: 'Mongolia', "label": "Mongolia"},
   {key: 'Mozambique', "label": "Mozambique"},
   {key: 'Myanmar', "label": "Myanmar"},
   {key: 'Namibia', "label": "Namibia"},
   {key: 'Nauru', "label": "Nauru"},
   {key: 'Nepal', "label": "Nepal"},
   {key: 'Nicaragua', "label": "Nicaragua"},
   {key: 'Níger', "label": "Níger"},
   {key: 'Nigeria', "label": "Nigeria"},
   {key: 'Norfolk Island', "label": "Norfolk Island"},
   {key: 'Noruega', "label": "Noruega"},
   {key: 'Nueva Caledonia', "label": "Nueva Caledonia"},
   {key: 'Nueva Zelanda', "label": "Nueva Zelanda"},
   {key: 'Omán', "label": "Omán"},
   {key: 'Países Bajos, Holanda', "label": "Países Bajos, Holanda"},
   {key: 'Pakistán', "label": "Pakistán"},
   {key: 'Panamá', "label": "Panamá"},
   {key: 'Papúa-Nueva Guinea', "label": "Papúa-Nueva Guinea"},
   {key: 'Paraguay', "label": "Paraguay"},
   {key: 'Perú', "label": "Perú"},
   {key: 'Polinesia Francesa', "label": "Polinesia Francesa"},
   {key: 'Polonia', "label": "Polonia"},
   {key: 'Portugal', "label": "Portugal"},
   {key: 'Puerto Rico', "label": "Puerto Rico"},
   {key: 'Qatar', "label": "Qatar"},
   {key: 'Reino Unido', "label": "Reino Unido"},
   {key: 'República Checa', "label": "República Checa"},
   {key: 'República Dominicana', "label": "República Dominicana"},
   {key: 'Reunión', "label": "Reunión"},
   {key: 'Ruanda', "label": "Ruanda"},
   {key: 'Rumanía', "label": "Rumanía"},
   {key: 'Rusia', "label": "Rusia"},
   {key: 'Sáhara Occidental', "label": "Sáhara Occidental"},
   {key: 'Samoa', "label": "Samoa"},
   {key: 'San Cristobal y Nevis', "label": "San Cristobal y Nevis"},
   {key: 'San Marino', "label": "San Marino"},
   {key: 'San Pedro y Miquelón', "label": "San Pedro y Miquelón"},
   {key: 'San Tomé y Príncipe', "label": "San Tomé y Príncipe"},
   {key: 'San Vincente y Granadinas', "label": "San Vincente y Granadinas"},
   {key: 'Santa Elena', "label": "Santa Elena"},
   {key: 'Santa Lucía', "label": "Santa Lucía"},
   {key: 'Senegal', "label": "Senegal"},
   {key: 'Serbia y Montenegro', "label": "Serbia y Montenegro"},
   {key: 'Seychelles', "label": "Seychelles"},
   {key: 'Sierra Leona', "label": "Sierra Leona"},
   {key: 'Singapur', "label": "Singapur"},
   {key: 'Siria', "label": "Siria"},
   {key: 'Somalia', "label": "Somalia"},
   {key: 'Sri Lanka', "label": "Sri Lanka"},
   {key: 'Sudáfrica', "label": "Sudáfrica"},
   {key: 'Sudán', "label": "Sudán"},
   {key: 'Suecia', "label": "Suecia"},
   {key: 'Suiza', "label": "Suiza"},
   {key: 'Surinam', "label": "Surinam"},
   {key: 'Swazilandia', "label": "Swazilandia"},
   {key: 'Tadjikistan', "label": "Tadjikistan"},
   {key: 'Tailandia', "label": "Tailandia"},
   {key: 'Taiwan', "label": "Taiwan"},
   {key: 'Tanzania', "label": "Tanzania"},
   {key: 'Timor Oriental', "label": "Timor Oriental"},
   {key: 'Togo', "label": "Togo"},
   {key: 'Tokelau', "label": "Tokelau"},
   {key: 'Tonga', "label": "Tonga"},
   {key: 'Trinidad y Tobago', "label": "Trinidad y Tobago"},
   {key: 'Túnez', "label": "Túnez"},
   {key: 'Turkmenistan', "label": "Turkmenistan"},
   {key: 'Turquía', "label": "Turquía"},
   {key: 'Tuvalu', "label": "Tuvalu"},
   {key: 'Ucrania', "label": "Ucrania"},
   {key: 'Uganda', "label": "Uganda"},
   {key: 'Uruguay', "label": "Uruguay"},
   {key: 'Uzbekistán', "label": "Uzbekistán"},
   {key: 'Vanuatu', "label": "Vanuatu"},
   {key: 'Venezuela', "label": "Venezuela"},
   {key: 'Vietnam', "label": "Vietnam"},
   {key: 'Wallis y Futuna', "label": "Wallis y Futuna"},
   {key: 'Yemen', "label": "Yemen"},
   {key: 'Zambia', "label": "Zambia"},
   {key: 'Zimbabwe', "label": "Zimbabwe"},
]

export default { countries, countriesLabel }