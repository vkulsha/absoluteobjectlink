�� "������������� ���� objectlink" (29.12.2017):
01.objectlink.gorm ������� ����� ������� gO � �.�.
02.���� �� ����� ������� � ����������
03.������ � ������� �������� ��� mainmenu
04.�������� ��������� � ��������� ��������
05.��� ������ �����������
06.���� ������ ���
07.������� ���� ��� �������������� � �����������/�������� ��������
08.���������� ���� �� ���������: �������,  ?��,?��
09.�������� ����
10.��� �������������
11.���� ����� ���� �� ������� � ������ openstreetmap
12.���� ������ �����
13.������ � ������� ����� �� �����
14.��� ����� �� �������, ���� ����� ������ � ������ ������ ��� ����� ���� � ���� �������� ������ ��� ��������� � ��������
15.������������� �������� �������, ������

���������:
JS+PHP:
interface ObjectLinkPhpProvider - ��������� ����� js � php objectlink
	invoke(funcName, funcParams, uid) //�������� http post ������� � php-������� ���������� objectlink (��� gOrm, �� �� ������, � ����������� ���������)

	gO(n) //��������� ������� �������� � ������ n
	gO(n, cid) //��������� oid ������� � ������ n,  ���������� � ��������/������� oid
	gL(oid1, oid2) //��������� id ����� ���� ��������� �������� oid1 � oid2, ���� ��� �������	
	gN(oid) //��������� ����� ������� �� oid
	cO(n) //����� � �������� (��� ����������) ������� � ������ n
	cO(n, cid) = cL(cO(n), cid) //����� �������� (��� ����������) ������� � ������ n � ��������� � �������-������ cid
	cO(n, �id, pid) = cL(cO(n, cid), pid) //����� �������� (��� ����������) ������� � ������ n � ��������� � �������-������ cid � �������-�������� pid
	cL(oid1,oid2) //����� � �������� (��� ����������) ����� ����� ��������� oid1 � oid2
	eO(oid) //�������� (���������) ������� oid � ���� ��� ������
	eL(oid1, oid2)// �������� (���������) ����� ����� ��������� oid1 � oid2
	uO(oid, n, c, d, u) //����� ������� �� oid � ���������� ��� ����������
	uL(oid1, oid1, c, d, u) //����� ����� ����� ��������� oid1 � oid2 � ���������� �� ����������
	
	gLogin({login, password}) //�������� ���������� ������, ���������� uid ������������ ��� �������� ����������� ��� null
	policy(uid, functionNames[]) //�������� ����������� ��������� ���� ������� functionNames[] ��� ������������ uid
	gT2({classNames[], classesLinks[][c1,c2],...})
	gAnd({oids[],...}) //���������� ������ ��������, ��������� �� ����� ���������, ���������� � oids[]
	createPolygonObject({coordinats[], oid}) //������� ������ ������ ������� � ������������ ������ ���������� �� ����������� coordinats[] � ��������� ������ �������� � �������� oid
	+getObjectLatLngs(oid) //���������� ������ �������� LatLng/PolyLine/Polygon, ��������� � �������� oid
	//�����: LatLng -> ������: "[Lat, Lng]" ��� "Lat Lng"; �����: PolyLine -> ������: "[[Lat, Lng],[Lat, Lng]]; �����: Polygon -> ������: "[[Lat, Lng],[Lat, Lng]]""

cD:
01 �����
	02 ���� ������� -> 01 �����
		03 ���� ������������� -> 02 ���� �������
		04 ���� ����� -> 02 ���� �������

	05 ������� ������� -> 01 �����
		06 ���������� ������� ��������� -> 05 ������� �������
		07 ���������� ������� ��������� -> 05 ������� �������
		
	08 ������� ������ ������� ������� -> 01 �����, 02 ���� �������, 05 ������� �������
		09 ��������� ���������� ���� ������� ������� -> 08 ������� ������ ������� �������, 03 ���� �������������, 06 ���������� ������� ���������, child:(12 gO,gL,gN,cO,cL,eO,eL,uO,uL ,gT,gAnd,gLogin,24 policy)
		10 �������� �������� -> 08 ������� ������ ������� �������, 04 ���� �����, 06 ���������� ������� ���������, child:(12 gO,gL,14 gN ,21 gT,gAnd,gLogin,24 policy)
		
	11 ������� ������� -> 01 �����, 08 ������� ������ ������� �������
		12 gO -> 11 ������� �������
		13 gL -> 11 ������� �������
		14 gN -> 11 ������� �������
		15 cO -> 11 ������� �������
		16 cL -> 11 ������� �������
		17 eO -> 11 ������� �������
		18 eL -> 11 ������� �������
		19 uO -> 11 ������� �������
		20 uL -> 11 ������� �������
		21 gT -> 11 ������� �������
		22 gAnd -> 11 ������� �������
		23 gLogin -> 11 ������� �������
		24 police -> 11 ������� �������
		
	25 ������������ ������� -> 01 �����, 02 ���� �������
		26 ������������� -> 25 ������������ �������, 03 ���� �������������
		27 ����� -> 25 ������������ �������, 04 ���� �����
		
	28 ����� ������������ ������� -> 01 �����, 25 ������������ �������
		29 admin -> 28 ����� ������������ �������, 26 �������������
		30 guest -> 28 ����� ������������ �������, 27 �����
		
	31 ������ ������������ ������� -> 01 �����, 25 ������������ �������
		32 admin -> 31 ������ ������������ �������, 26 �������������
		33 guest -> 31 ������ ������������ �������, 27 �����
		
	34 ������ -> 01 �����
		35 ���� ������ -> 31 ������
		
	36 �������� ����� ���� ������� -> 01 �����, 02 ���� �������
		37 �������� ����� ���� ������������� -> 36 �������� ����� ���� �������, 03 ���� �������������
		38 �������� ����� ���� ����� -> 36 �������� ����� ���� �������, 04 ���� �����, child:(35 ���� ������)
	
	
	
[�����]
	[tileLayer]
	[tileLayerParams]
	[setViewLatLng]
	[setViewZoom]
	
	[��������� �� �����]
		[������� ���������]
			"L.marker"
			"L.polyline"
			"L.polygon"
			"L.cirlce"
		[��������� ������� ���������]
		[���������� �� �����]
	
	map
		"//mt{s}.googleapis.com/vt?lyrs=s,h&x={x}&y={y}&z={z}"
		"{maxZoom: 18, subdomains: [0,1,2,3]}"
		"[65, 100]"
		"3"
		
		"��������� �� ����� 123"
			"L.polyline"
			"{color:#000, weight:1}"
			"[[30.1,50.1],[31.2,51.2],[32.3,52.3]]"
			
		"��������� �� ����� 234"
			"L.marker"
			"{icon: L.icon({iconUrl: 'images/logo.png'})}"
			"[30.1,50.1]"

	
	
	
	
	