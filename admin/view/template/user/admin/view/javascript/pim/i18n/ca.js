/**
 * Catalan translation
 * @author Sergio Jovani <lesergi@gmail.com>
 * @version 2011-11-13
 */
if (elFinder && elFinder.prototype && typeof(elFinder.prototype.i18) == 'object') {
	elFinder.prototype.i18.ca = {
		translator : 'Sergio Jovani &lt;lesergi@gmail.com&gt;',
		language   : 'Català',
		direction  : 'ltr',
		messages   : {
			
			/********************************** errors **********************************/
			'error'                : 'Error',
			'errUnknown'           : 'Error desconegut.',
			'errUnknownCmd'        : 'Ordre desconeguda.',
			'errJqui'              : 'La configuració de jQuery UI no és vàlida. S\'han d\'incloure els components "selectable", "draggable" i "droppable".',
			'errNode'              : 'elFinder necessita crear elements DOM.',
			'errURL'               : 'La configuració de l\'elFinder no és vàlida! L\'opció URL no està configurada.',
			'errAccess'            : 'Accés denegat.',
			'errConnect'           : 'No s\'ha pogut connectar amb el rerefons.',
			'errAbort'             : 'S\'ha interromput la connexió.',
			'errTimeout'           : 'Temps de connexió excedit.',
			'errNotFound'          : 'No s\'ha trobat el rerefons.',
			'errResponse'          : 'La resposta del rerefons no és vàlida.',
			'errConf'              : 'La configuració del rerefons no és vàlida.',
			'errJSON'              : 'No està instal·lat el mòdul JSON del PHP.',
			'errNoVolumes'         : 'No s\'han trobat volums llegibles.',
			'errCmdParams'         : 'Els paràmetres per l\'ordre "$1" no són vàlids.',
			'errDataNotJSON'       : 'Les dades no són JSON.',
			'errDataEmpty'         : 'Les dades estan buides.',
			'errCmdReq'            : 'La sol·licitud del rerefons necessita el nom de l\'ordre.',
			'errOpen'              : 'No s\'ha pogut obrir "$1".',
			'errNotFolder'         : 'L\'objecte no és una carpeta.',
			'errNotFile'           : 'L\'objecte no és un fitxer.',
			'errRead'              : 'No s\'ha pogut llegir "$1".',
			'errWrite'             : 'No s\'ha pogut escriure a "$1".',
			'errPerm'              : 'Permís denegat.',
			'errLocked'            : '"$1" està bloquejat i no podeu canviar-li el nom, moure-lo ni suprimir-lo.',
			'errExists'            : 'Ja existeix un fitxer anomenat "$1".',
			'errInvName'           : 'El nom de fitxer no és vàlid.',
			'errFolderNotFound'    : 'No s\'ha trobat la carpeta.',
			'errFileNotFound'      : 'No s\'ha trobat el fitxer.',
			'errTrgFolderNotFound' : 'No s\'ha trobat la carpeta de destí "$1".',
			'errPopup'             : 'El navegador ha evitat obrir una finestra emergent. Autoritzeu-la per obrir el fitxer.',
			'errMkdir'             : 'No s\'ha pogut crear la carpeta "$1".',
			'errMkfile'            : 'No s\'ha pogut crear el fitxer "$1".',
			'errRename'            : 'No s\'ha pogut canviar el nom de "$1".',
			'errCopyFrom'          : 'No està permès copiar fitxers des del volum "$1".',
			'errCopyTo'            : 'No està permès copiar fitxers al volum "$1".',
			'errUploadCommon'      : 'S\'ha produït un error en la càrrega.',
			'errUpload'            : 'No s\'ha pogut carregar "$1".',
			'errUploadNoFiles'     : 'No s\'han trobat fitxers per carregar.',
			'errMaxSize'           : 'Les dades excedeixen la mida màxima permesa.',
			'errFileMaxSize'       : 'El fitxer excedeix la mida màxima permesa.',
			'errUploadMime'        : 'El tipus de fitxer no està permès.',
			'errUploadTransfer'    : 'S\'ha produït un error en transferir "$1".', 
			'errSave'              : 'No s\'ha pogut desar "$1".',
			'errCopy'              : 'No s\'ha pogut copiar "$1".',
			'errMove'              : 'No s\'ha pogut moure "$1".',
			'errCopyInItself'      : 'No s\'ha pogut copiar "$1" a si mateix.',
			'errRm'                : 'No s\'ha pogut suprimir "$1".',
			'errExtract'           : 'No s\'han pogut extreure els fitxers de "$1".',
			'errArchive'           : 'No s\'ha pogut crear l\'arxiu.',
			'errArcType'           : 'El tipus d\'arxiu no està suportat.',
			'errNoArchive'         : 'El fitxer no és un arxiu o és un tipus no suportat.',
			'errCmdNoSupport'      : 'El rerefons no suporta aquesta ordre.',
			'errReplByChild'       : 'No es pot reemplaçar la carpeta “$1” per un element que conté.',
			'errArcSymlinks'       : 'Per raons de seguretat, no es permet extreure arxius que contenen enllaços simbòlics.',
			'errArcMaxSize'        : 'Els fitxers de l\'arxiu excedeixen la mida màxima permesa.',
			'errResize'            : 'No s\'ha pogut redimensionar "$1".',
			'errUsupportType'      : 'El tipus de fitxer no està suportat.',
			
			/******************************* commands names ********************************/
			'cmdarchive'   : 'Crea arxiu',
			'cmdback'      : 'Enrere',
			'cmdcopy'      : 'Copia',
			'cmdcut'       : 'Retalla',
			'cmddownload'  : 'Descarrega',
			'cmdduplicate' : 'Duplica',
			'cmdedit'      : 'Edita el fitxer',
			'cmdextract'   : 'Extreu els fitxers de l\'arxiu',
			'cmdforward'   : 'Endavant',
			'cmdgetfile'   : 'Selecciona els fitxers',
			'cmdhelp'      : 'Quant a aquest programari',
			'cmdhome'      : 'Inici',
			'cmdinfo'      : 'Obté informació',
			'cmdmkdir'     : 'Nova carpeta',
			'cmdmkfile'    : 'Nou fitxer de text',
			'cmdopen'      : 'Obre',
			'cmdpaste'     : 'Enganxa',
			'cmdquicklook' : 'Previsualitza',
			'cmdreload'    : 'Torna a carregar',
			'cmdrename'    : 'Canvia el nom',
			'cmdrm'        : 'Suprimeix',
			'cmdsearch'    : 'Cerca fitxers',
			'cmdup'        : 'Vés al directori superior',
			'cmdupload'    : 'Carrega fitxers',
			'cmdview'      : 'Visualitza',
			'cmdresize'    : 'Redimensiona la imatge',
			'cmdsort'      : 'Ordena',
			
			/*********************************** buttons ***********************************/ 
			'btnClose'  : 'Tanca',
			'btnSave'   : 'Desa',
			'btnRm'     : 'Suprimeix',
			'btnApply'  : 'Aplica',
			'btnCancel' : 'Cancel·la',
			'btnNo'     : 'No',
			'btnYes'    : 'Sí',
			
			/******************************** notifications ********************************/
			'ntfopen'     : 'S\'està obrint la carpeta',
			'ntffile'     : 'S\'està obrint el fitxer',
			'ntfreload'   : 'S\'està tornant a carregar el contingut de la carpeta',
			'ntfmkdir'    : 'S\'està creant el directori',
			'ntfmkfile'   : 'S\'estan creant el fitxers',
			'ntfrm'       : 'S\'estan suprimint els fitxers',
			'ntfcopy'     : 'S\'estan copiant els fitxers',
			'ntfmove'     : 'S\'estan movent els fitxers',
			'ntfprepare'  : 'S\'està preparant per copiar fitxers',
			'ntfrename'   : 'S\'estan canviant els noms del fitxers',
			'ntfupload'   : 'S\'estan carregant els fitxers',
			'ntfdownload' : 'S\'estan descarregant els fitxers',
			'ntfsave'     : 'S\'estan desant els fitxers',
			'ntfarchive'  : 'S\'està creant l\'arxiu',
			'ntfextract'  : 'S\'estan extreient els fitxers de l\'arxiu',
			'ntfsearch'   : 'S\'estan cercant els fitxers',
			'ntfsmth'     : 'S\'estan realitzant operacions',
      'ntfloadimg'  : 'S\'està carregant la imatge',
			
			/************************************ dates **********************************/
			'dateUnknown' : 'desconegut',
			'Today'       : 'Avui',
			'Yesterday'   : 'Ahir',
			'Jan'         : 'gen.',
			'Feb'         : 'febr.',
			'Mar'         : 'març',
			'Apr'         : 'abr.',
			'May'         : 'maig',
			'Jun'         : 'juny',
			'Jul'         : 'jul.',
			'Aug'         : 'ag.',
			'Sep'         : 'set.',
			'Oct'         : 'oct.',
			'Nov'         : 'nov.',
			'Dec'         : 'des.',
			
			/******************************** sort variants ********************************/
			'sortnameDirsFirst' : 'per nom (carpetes primer)', 
			'sortkindDirsFirst' : 'per tipus (carpetes primer)', 
			'sortsizeDirsFirst' : 'per mida (carpetes primer)', 
			'sortdateDirsFirst' : 'per data (carpetes primer)', 
			'sortname'          : 'per nom', 
			'sortkind'          : 'per tipus', 
			'sortsize'          : 'per mida',
			'sortdate'          : 'per data',
			
			/********************************** messages **********************************/
			'confirmReq'      : 'Es necessita confirmació',
			'confirmRm'       : 'Voleu suprimir els fitxers?<br />L\'acció es podrà desfer!',
			'confirmRepl'     : 'Voleu reemplaçar el fitxer antic amb el nou?',
			'apllyAll'        : 'Aplica a tot',
			'name'            : 'Nom',
			'size'            : 'Mida',
			'perms'           : 'Permisos',
			'modify'          : 'Modificat',
			'kind'            : 'Tipus',
			'read'            : 'llegir',
			'write'           : 'escriure',
			'noaccess'        : 'sense accés',
			'and'             : 'i',
			'unknown'         : 'desconegut',
			'selectall'       : 'Selecciona tots els fitxers',
			'selectfiles'     : 'Selecciona el(s) fitxer(s)',
			'selectffile'     : 'Selecciona el primer fitxer',
			'selectlfile'     : 'Selecciona l\'últim fitxer',
			'viewlist'        : 'Vista en llista',
			'viewicons'       : 'Vista en icones',
			'places'          : 'Llocs',
			'calc'            : 'Calcula', 
			'path'            : 'Camí',
			'aliasfor'        : 'Àlies per',
			'locked'          : 'Bloquejat',
			'dim'             : 'Dimensions',
			'files'           : 'Fitxers',
			'folders'         : 'Carpetes',
			'items'           : 'Elements',
			'yes'             : 'sí',
			'no'              : 'no',
			'link'            : 'Enllaç',
			'searcresult'     : 'Resultats de la cerca',  
			'selected'        : 'Elements seleccionats',
			'about'           : 'Quant a',
			'shortcuts'       : 'Dreceres',
			'help'            : 'Ajuda',
			'webfm'           : 'Gestor de fitxers web',
			'ver'             : 'Versió',
			'protocolver'     : 'versió de protocol',
			'homepage'        : 'Pàgina del projecte',
			'docs'            : 'Documentació',
			'github'          : 'Bifurca\'ns a GitHub',
			'twitter'         : 'Segueix-nos a Twitter',
			'facebook'        : 'Uniu-vos a Facebook',
			'team'            : 'Equip',
			'chiefdev'        : 'cap desenvolupador',
			'developer'       : 'desenvolupador',
			'contributor'     : 'col·laborador',
			'maintainer'      : 'mantenidor',
			'translator'      : 'traductor',
			'icons'           : 'Icones',
			'dontforget'      : 'i no oblideu agafar la vostra tovallola',
			'shortcutsof'     : 'Les dreceres estan inhabilitades',
			'dropFiles'       : 'Arrossegueu els fitxers aquí',
			'or'              : 'o',
			'selectForUpload' : 'Seleccioneu els fitxer a carregar',
			'moveFiles'       : 'Mou els fitxers',
			'copyFiles'       : 'Copia els fitxers',
			'rmFromPlaces'    : 'Suprimeix dels llocs',
			'untitled folder' : 'carpeta sense nom',
			'untitled file.txt' : 'fitxer sense nom.txt',
			'aspectRatio'     : 'Relació d\'aspecte',
			'scale'           : 'Escala',
			'width'           : 'Amplada',
			'height'          : 'Alçada',
      'mode'            : 'Mode',
      'resize'          : 'Redimensiona',
      'crop'            : 'Retalla',
			
			/********************************** mimetypes **********************************/
			'kindUnknown'     : 'Desconegut',
			'kindFolder'      : 'Carpeta',
			'kindAlias'       : 'Àlies',
			'kindAliasBroken' : 'Àlies no vàlid',
			// applications
			'kindApp'         : 'Aplicació',
			'kindPostscript'  : 'Document Postscript',
			'kindMsOffice'    : 'Document del Microsoft Office',
			'kindMsWord'      : 'Document del Microsoft Word',
			'kindMsExcel'     : 'Document del Microsoft Excel',
			'kindMsPP'        : 'Presentació del Microsoft Powerpoint',
			'kindOO'          : 'Document de l\'Open Office',
			'kindAppFlash'    : 'Aplicació Flash',
			'kindPDF'         : 'Document PDF',
			'kindTorrent'     : 'Fitxer Bittorrent',
			'kind7z'          : 'Arxiu 7z',
			'kindTAR'         : 'Arxiu TAR',
			'kindGZIP'        : 'Arxiu GZIP',
			'kindBZIP'        : 'Arxiu BZIP',
			'kindZIP'         : 'Arxiu ZIP',
			'kindRAR'         : 'Arxiu RAR',
			'kindJAR'         : 'Fitxer JAR de Java',
			'kindTTF'         : 'Tipus de lletra True Type',
			'kindOTF'         : 'Tipus de lletra Open Type',
			'kindRPM'         : 'Paquet RPM',
			// texts
			'kindText'        : 'Document de text',
			'kindTextPlain'   : 'Document de text net',
			'kindPHP'         : 'Codi PHP',
			'kindCSS'         : 'Full d\'estils CSS',
			'kindHTML'        : 'Document HTML',
			'kindJS'          : 'Codi Javascript',
			'kindRTF'         : 'Document RTF',
			'kindC'           : 'Codi C',
			'kindCHeader'     : 'Codi de caçalera C',
			'kindCPP'         : 'Codi C++',
			'kindCPPHeader'   : 'Codi de caçalera C++',
			'kindShell'       : 'Script Unix',
			'kindPython'      : 'Codi Python',
			'kindJava'        : 'Codi Java',
			'kindRuby'        : 'Codi Ruby',
			'kindPerl'        : 'Script Perl',
			'kindSQL'         : 'Codi SQL',
			'kindXML'         : 'Document XML',
			'kindAWK'         : 'Codi AWK',
			'kindCSV'         : 'Document CSV',
			'kindDOCBOOK'     : 'Document XML de Docbook',
			// images
			'kindImage'       : 'Imatge',
			'kindBMP'         : 'Imatge BMP',
			'kindJPEG'        : 'Imatge JPEG',
			'kindGIF'         : 'Imatge GIF',
			'kindPNG'         : 'Imatge PNG',
			'kindTIFF'        : 'Imatge TIFF',
			'kindTGA'         : 'Imatge TGA',
			'kindPSD'         : 'Imatge Adobe Photoshop',
			'kindXBITMAP'     : 'Imatge X bitmap',
			'kindPXM'         : 'Imatge Pixelmator',
			// media
			'kindAudio'       : 'Fitxer d\'àudio',
			'kindAudioMPEG'   : 'Fitxer d\'àudio MPEG',
			'kindAudioMPEG4'  : 'Fitxer d\'àudio MPEG-4',
			'kindAudioMIDI'   : 'Fitxer d\'àudio MIDI',
			'kindAudioOGG'    : 'Fitxer d\'àudio Ogg Vorbis',
			'kindAudioWAV'    : 'Fitxer d\'àudio WAV',
			'AudioPlaylist'   : 'Llista de reproducció MP3',
			'kindVideo'       : 'Fitxer de vídeo',
			'kindVideoDV'     : 'Fitxer de vídeo DV',
			'kindVideoMPEG'   : 'Fitxer de vídeo MPEG',
			'kindVideoMPEG4'  : 'Fitxer de vídeo MPEG-4',
			'kindVideoAVI'    : 'Fitxer de vídeo AVI',
			'kindVideoMOV'    : 'Fitxer de vídeo Quick Time',
			'kindVideoWM'     : 'Fitxer de vídeo Windows Media',
			'kindVideoFlash'  : 'Fitxer de vídeo Flash',
			'kindVideoMKV'    : 'Fitxer de vídeo Matroska',
			'kindVideoOGG'    : 'Fitxer de vídeo Ogg'
		}
	}
}

