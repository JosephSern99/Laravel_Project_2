Imports System.Web
Imports System.Web.Services
Imports System.Web.Services.Protocols
Imports System.DateTime.Today

Imports System.Data
Imports System.Data.SqlClient
Imports System.IO
Imports System.Text
Imports System.Math

Imports System.Web.Script.Services
Imports System.Collections.Generic
Imports System.Linq

<WebService(Namespace:="http://tempuri.org/")> _
<WebServiceBinding(ConformsTo:=WsiProfiles.BasicProfile1_1)> _
<Global.Microsoft.VisualBasic.CompilerServices.DesignerGenerated()> _
Public Class OEOrderEntry

    Inherits System.Web.Services.WebService
    Public mDBLinkCmpRW As AccpacCOMAPI.AccpacDBLink
    Public mDBLinkSysRW As AccpacCOMAPI.AccpacDBLink
    Public MySession As New AccpacCOMAPI.AccpacSession
    Public errAccpac As AccpacCOMAPI.AccpacErrors

    Private OEORD1header As AccpacCOMAPI.AccpacView
    Private OEORD1headerFields As AccpacCOMAPI.AccpacViewFields
    Private OEORD1detail1 As AccpacCOMAPI.AccpacView
    Private OEORD1detail1Fields As AccpacCOMAPI.AccpacViewFields
    Private OEORD1detail2 As AccpacCOMAPI.AccpacView
    Private OEORD1detail2Fields As AccpacCOMAPI.AccpacViewFields
    Private OEORD1detail3 As AccpacCOMAPI.AccpacView
    Private OEORD1detail3Fields As AccpacCOMAPI.AccpacViewFields
    Private OEORD1detail4 As AccpacCOMAPI.AccpacView
    Private OEORD1detail4Fields As AccpacCOMAPI.AccpacViewFields
    Private OEORD1detail5 As AccpacCOMAPI.AccpacView
    Private OEORD1detail5Fields As AccpacCOMAPI.AccpacViewFields
    Private OEORD1detail6 As AccpacCOMAPI.AccpacView
    Private OEORD1detail6Fields As AccpacCOMAPI.AccpacViewFields
    Private OEORD1detail7 As AccpacCOMAPI.AccpacView
    Private OEORD1detail7Fields As AccpacCOMAPI.AccpacViewFields
    Private OEORD1detail8 As AccpacCOMAPI.AccpacView
    Private OEORD1detail8Fields As AccpacCOMAPI.AccpacViewFields
    Private OEORD1detail9 As AccpacCOMAPI.AccpacView
    Private OEORD1detail9Fields As AccpacCOMAPI.AccpacViewFields
    Private OEORD1detail10 As AccpacCOMAPI.AccpacView
    Private OEORD1detail10Fields As AccpacCOMAPI.AccpacViewFields
	
	Private OEORD1detail11 As AccpacCOMAPI.AccpacView
    Private OEORD1detail11Fields As AccpacCOMAPI.AccpacViewFields
    Private OEORD1detail12 As AccpacCOMAPI.AccpacView
    Private OEORD1detail12Fields As AccpacCOMAPI.AccpacViewFields
	
    Private viewOEHeader As AccpacDataSrc.AccpacDataSource
    Public OeNumber As String

    Public Function OpenAccpacTable() As Boolean

        Dim ComposeArray(100) As AccpacCOMAPI.AccpacView

        mDBLinkCmpRW.OpenView("OE0520", OEORD1header)
        mDBLinkCmpRW.OpenView("OE0500", OEORD1detail1)
        mDBLinkCmpRW.OpenView("OE0740", OEORD1detail2)
        mDBLinkCmpRW.OpenView("OE0180", OEORD1detail3)
        mDBLinkCmpRW.OpenView("OE0526", OEORD1detail4)
        mDBLinkCmpRW.OpenView("OE0522", OEORD1detail5)
        mDBLinkCmpRW.OpenView("OE0508", OEORD1detail6)
        mDBLinkCmpRW.OpenView("OE0507", OEORD1detail7)
        mDBLinkCmpRW.OpenView("OE0501", OEORD1detail8)
        mDBLinkCmpRW.OpenView("OE0502", OEORD1detail9)
        mDBLinkCmpRW.OpenView("OE0504", OEORD1detail10)
		mDBLinkCmpRW.OpenView("OE0506", OEORD1detail11)
        mDBLinkCmpRW.OpenView("OE0503", OEORD1detail12)

        OEORD1headerFields = OEORD1header.Fields
        OEORD1detail1Fields = OEORD1detail1.Fields
        OEORD1detail2Fields = OEORD1detail2.Fields
        OEORD1detail3Fields = OEORD1detail3.Fields
        OEORD1detail4Fields = OEORD1detail4.Fields
        OEORD1detail5Fields = OEORD1detail5.Fields
        OEORD1detail6Fields = OEORD1detail6.Fields
        OEORD1detail7Fields = OEORD1detail7.Fields
        OEORD1detail8Fields = OEORD1detail8.Fields
        OEORD1detail9Fields = OEORD1detail9.Fields
        OEORD1detail10Fields = OEORD1detail10.Fields
		
		OEORD1detail11Fields = OEORD1detail11.Fields
        OEORD1detail12Fields = OEORD1detail12.Fields

        ReDim ComposeArray(100)
        ComposeArray(0) = OEORD1detail1
        ComposeArray(1) = Nothing
        ComposeArray(2) = OEORD1detail3
        ComposeArray(3) = OEORD1detail2
        ComposeArray(4) = OEORD1detail4
        ComposeArray(5) = OEORD1detail5
        OEORD1header.Compose(ComposeArray)

        ReDim ComposeArray(100)
        ComposeArray(0) = OEORD1header
        ComposeArray(1) = OEORD1detail8
        ComposeArray(2) = OEORD1detail12
        ComposeArray(3) = OEORD1detail9
		ComposeArray(4) = OEORD1detail6
        ComposeArray(5) = OEORD1detail7
        OEORD1detail1.Compose(ComposeArray)

        ReDim ComposeArray(100)
        ComposeArray(0) = OEORD1header
        OEORD1detail2.Compose(ComposeArray)

        ReDim ComposeArray(100)
        ComposeArray(0) = OEORD1header
        ComposeArray(1) = OEORD1detail1
        OEORD1detail3.Compose(ComposeArray)

        ReDim ComposeArray(100)
        ComposeArray(0) = OEORD1header
        OEORD1detail4.Compose(ComposeArray)

        ReDim ComposeArray(100)
        ComposeArray(0) = OEORD1header
        OEORD1detail5.Compose(ComposeArray)

        ReDim ComposeArray(100)
        ComposeArray(0) = OEORD1detail1
        OEORD1detail6.Compose(ComposeArray)

        ReDim ComposeArray(100)
        ComposeArray(0) = OEORD1detail1
        OEORD1detail7.Compose(ComposeArray)


        ReDim ComposeArray(100)
        ComposeArray(0) = OEORD1detail1
        OEORD1detail8.Compose(ComposeArray)

        ReDim ComposeArray(100)
        ComposeArray(0) = OEORD1detail1
		ComposeArray(1) = OEORD1detail10
		ComposeArray(2) = OEORD1detail11
        OEORD1detail9.Compose(ComposeArray)


        ReDim ComposeArray(100)
        ComposeArray(0) = OEORD1detail9
        OEORD1detail10.Compose(ComposeArray)
		
		 ReDim ComposeArray(100)
        ComposeArray(0) = OEORD1detail9
        OEORD1detail11.Compose(ComposeArray)
		
		 ReDim ComposeArray(100)
        ComposeArray(0) = OEORD1detail1
        OEORD1detail12.Compose(ComposeArray)

    End Function

    Public Function OpenAccpacSession(ByVal Database As String) As String
        Dim User As String
        Dim Password As String
        Dim Company As String

		Dim today As String = DateTime.Now.ToString("yyyyMMdd")
		Dim filePath As String = AppDomain.CurrentDomain.BaseDirectory & "\logs"
		Dim logFile As String = filePath.ToString & "\" & today & "_LOGON_Log.txt"
		DIm fileSystem = My.Computer.FileSystem 
        User = System.Configuration.ConfigurationManager.AppSettings("UserName").ToString
        Password = System.Configuration.ConfigurationManager.AppSettings("Password").ToString
        Company = System.Configuration.ConfigurationManager.AppSettings("Company").ToString
		
		fileSystem.WriteAllText(logFile, DateTime.Now.ToString("yyyy-MM-dd HH:mm:ss") & ": Open Session for User '" & User & "', Password '" & Password & "', Company '" & Company & "'" & vbcrlf, True)
		
        'Company = System.Configuration.ConfigurationManager.AppSettings("Company").ToString

        MySession.Init("", "XY", "XY1000", "62A") '*** Session Initialize
        MySession.Open("ADMIN", "WHSPL", "IHAUTE", Now.Date, 0, "") '*** Opening Session 

        mDBLinkCmpRW = (MySession.OpenDBLink(AccpacCOMAPI.tagDBLinkTypeEnum.DBLINK_COMPANY, AccpacCOMAPI.tagDBLinkFlagsEnum.DBLINK_FLG_READWRITE))
        mDBLinkSysRW = (MySession.OpenDBLink(AccpacCOMAPI.tagDBLinkTypeEnum.DBLINK_SYSTEM, AccpacCOMAPI.tagDBLinkFlagsEnum.DBLINK_FLG_READWRITE))
        '    OpenAccpacSession = True
        Return MySession.CompanyName
    End Function
	
	<WebMethod()> _
	Public Function OEORDH_Post(ByVal iDatabase As String, ByVal CUSTOMER As String, ByVal DESC As String, _
		ByVal ORDDATE As String, ByVal SHPNAME As String, ByVal EXPDATE As String, ByVal LOCATION As String, _
		ByVal SALESPER1 As String, ByVal SHIPVIA As String, ByVal PONUMBER As String, ByVal REFERENCE As String, _
		ByVal INVDISCPER As Decimal) _
		As List(Of List(Of String))
		Dim today As String = DateTime.Now.ToString("yyyyMMddHHmmss")
		
		Dim filePath As String = AppDomain.CurrentDomain.BaseDirectory & "\logs"
		Dim logFile As String = filePath.ToString & "\" & today & "_" & REFERENCE & "_OEORDH_Log.txt"
		DIm fileSystem = My.Computer.FileSystem 
		
		fileSystem.WriteAllText(logFile, DateTime.Now.ToString("yyyy-MM-dd HH:mm:ss") & ": Open Session for Database " & iDatabase & vbcrlf, True)
		
		Call OpenAccpacSession(iDatabase)
        Call OpenAccpacTable()
		
		Dim result As New List(Of List(Of String))
		Dim Msg As New List(Of String)
		Dim Warning As New List(Of String)
		Dim Err As New List(Of String)
		Dim Ref As New List(Of String)
		
		Try
			fileSystem.WriteAllText(logFile, DateTime.Now.ToString("yyyy-MM-dd HH:mm:ss") & ": Start Posting OEORDH For " & REFERENCE & vbcrlf, True)
			
			With OEORD1header
				.Browse("", 1)
				.Fetch()
				.RecordCreate(False)
				.Fields.Item("CUSTOMER").Value = CUSTOMER
				.Fields.Item("PROCESSCMD").PutWithoutVerification("1")
				.Fields.Item("DESC").Value = DESC
				.Fields.Item("ORDDATE").Value = ORDDATE
				IF SHPNAME <> "" THEN
				.Fields.Item("SHIPTO").Value = SHPNAME
				END IF
				.Fields.Item("EXPDATE").Value = EXPDATE
				.Fields.Item("REQUESDATE").Value = EXPDATE
				.Fields.Item("LOCATION").Value = LOCATION
				.Fields.Item("SHIPVIA").Value = SHIPVIA
				.Fields.Item("PONUMBER").Value = PONUMBER
				.Fields.Item("REFERENCE").Value = REFERENCE
				'.Fields.Item("TAXGROUP").Value = "GST0"
				.Fields.Item("SALESPER1").Value = SALESPER1
				.Fields.Item("SALESPLT1").Value = 100.00
				.Process()
				
				'OEORD1detail5.Fields.Item("OPTFIELD").PutWithoutVerification("PREPAREBY")
				'OEORD1detail5.Read()
				'OEORD1detail5.Fields.Item("VALIFTEXT").Value = PREPAREBY
				'OEORD1detail5.Update()
				
				.Insert()
				.Fields.Item("INVDISCPER").Value = INVDISCPER
				.Update()
				
			End With
			
			Ref.Add(OEORD1header.Fields.Item("ORDNUMBER").Value)
			fileSystem.WriteAllText(logFile, DateTime.Now.ToString("yyyy-MM-dd HH:mm:ss") & ": End Posting OEORDH " & vbcrlf, True)
		Catch e As Exception
			Dim ErrMsg As String
			
			If MySession.Errors.Count > 0 Then
				For index As Integer = 0 To MySession.Errors.Count - 1
					ErrMsg = "Exception: " & MySession.Errors.Item(index).ToString()
					
					Err.Add(ErrMsg)
					fileSystem.WriteAllText(logFile, DateTime.Now.ToString("yyyy-MM-dd HH:mm:ss") & ": " & ErrMsg & vbcrlf, True)
				Next
			Else
				ErrMsg = "Exception:" & vbcrlf & "Message: " & e.Message.ToString & vbcrlf & "Source: " & e.Source.ToString & vbcrlf & "Stack Trace: " & e.StackTrace.ToString & vbcrlf & "Target Site: " & e.TargetSite.ToString
				fileSystem.WriteAllText(logFile, DateTime.Now.ToString("yyyy-MM-dd HH:mm:ss") & ": " & ErrMsg & vbcrlf, True)
				Err.Add(ErrMsg)
			End If
		End Try
		
		If MySession.Errors.Count > 0 Then
			Dim Warn As String
			For index As Integer = 0 To MySession.Errors.Count - 1
				Warn = "Warning: " & MySession.Errors.Item(index).ToString()
				
				Warning.Add(Warn)
				fileSystem.WriteAllText(logFile, DateTime.Now.ToString("yyyy-MM-dd HH:mm:ss") & ": " & Warn & vbcrlf, True)
			Next
		End If
		
		If Err.Count > 0 Then
			Msg.Add("Fail")
		Else
			Msg.Add("Success")
		End If
		
		result.Add(Msg)
		result.Add(Ref)
		result.Add(Warning)
		result.Add(Err)
		
		fileSystem.WriteAllText(logFile, DateTime.Now.ToString("yyyy-MM-dd HH:mm:ss") & ": Close Session for Database " & iDatabase & vbcrlf, True)
		MySession.Close()
		
		Return result
	End Function
	
	<WebMethod()> _
	Public Function OEORDD_Post(ByVal iDatabase As String, ByVal ORDNUMBER As String, ByVal ITEMNO As String, ByVal LOCATION As String, _
		ByVal QTYORDERED As Integer, ByVal ORDUNIT As String, ByVal PRIUNTPRC As Decimal, ByVal DESC As String, ByVal FOC As String, ByVal COMMENTS As String) _
		As List(Of List(Of String))
		
		Dim comment As String = COMMENTS
		Dim today As String = DateTime.Now.ToString("yyyyMMdd")
		
		Dim filePath As String = AppDomain.CurrentDomain.BaseDirectory & "\logs"
		Dim logFile As String = filePath.ToString & "\" & today & "_" & ORDNUMBER & "_OEORDD_Log.txt"
		DIm fileSystem = My.Computer.FileSystem 
		
		fileSystem.WriteAllText(logFile, DateTime.Now.ToString("yyyy-MM-dd HH:mm:ss") & ": Open Session for Database " & iDatabase & vbcrlf, True)
		
		Call OpenAccpacSession(iDatabase)
        Call OpenAccpacTable()
		
		Dim result As New List(Of List(Of String))
		Dim Msg As New List(Of String)
		Dim Warning As New List(Of String)
		Dim Err As New List(Of String)
		
		Try
			fileSystem.WriteAllText(logFile, DateTime.Now.ToString("yyyy-MM-dd HH:mm:ss") & ": Start Posting OEORDD " & vbcrlf, True)
			fileSystem.WriteAllText(logFile, DateTime.Now.ToString("yyyy-MM-dd HH:mm:ss") & ": Reading " & ORDNUMBER & vbcrlf, True)
			
			With OEORD1header
                .Browse("", 1)
                .Fields.Item("ORDNUMBER").Value = ORDNUMBER
                .Order = 1
                .Read()
            End With
			
			fileSystem.WriteAllText(logFile, DateTime.Now.ToString("yyyy-MM-dd HH:mm:ss") & ": Description: " & DESC & vbcrlf, True)
			
			IF comment = "" AND FOC = "Y" THEN
                comment = "FOC"
            END IF

            With OEORD1detail1
                .GoBottom()
                .RecordCreate(0)
                .Fields.Item("ITEM").Value = ITEMNO
                .Fields.Item("DESC").Value = DESC
                '.Fields.Item("PROCESSCMD").PutWithoutVerification("1")         ' Line Number
                .Fields.Item("LOCATION").Value = LOCATION
                .Fields.Item("ORDUNIT").Value = ORDUNIT
                .Fields.Item("QTYORDERED").Value = QTYORDERED
                .Fields.Item("PRIUNTPRC").Value = PRIUNTPRC
				.Process()
				
				If comment <> "" Then
					OEORD1detail3.Browse("(COINTYPE=1)", 1)
					OEORD1detail3.RecordClear()
					OEORD1detail3.RecordCreate(0)
					OEORD1detail3.Fields.Item("COIN").Value = comment
					OEORD1detail3.Process()
					OEORD1detail3.Insert()
					
					.Fields.Item("COMMINST").Value = "1"
                End If
				
				'If FOC = "Y" Then
				'.Fields.Item("CATEGORY").Value = "FOC"
				'.Process()
				'.Fields.Item("TCLASS1").Value = "4"
				
				'End If
				
                .Insert()
                .Fields.Item("LINENUM").PutWithoutVerification(-1)         ' Line Number
                .Update()
            End With
            With OEORD1header
                .Update()
            End With

			fileSystem.WriteAllText(logFile, DateTime.Now.ToString("yyyy-MM-dd HH:mm:ss") & ": End Posting OEORDD " & vbcrlf, True)
		Catch e As Exception
			Dim ErrMsg As String
			
			If MySession.Errors.Count > 0 Then
				For index As Integer = 0 To MySession.Errors.Count - 1
					ErrMsg = "Exception: " & MySession.Errors.Item(index).ToString()
					
					Err.Add(ErrMsg)
					fileSystem.WriteAllText(logFile, DateTime.Now.ToString("yyyy-MM-dd HH:mm:ss") & ": " & ErrMsg & vbcrlf, True)
				Next
			Else
				ErrMsg = "Exception:" & vbcrlf & "Message: " & e.Message.ToString & vbcrlf & "Source: " & e.Source.ToString & vbcrlf & "Stack Trace: " & e.StackTrace.ToString & vbcrlf & "Target Site: " & e.TargetSite.ToString
				fileSystem.WriteAllText(logFile, DateTime.Now.ToString("yyyy-MM-dd HH:mm:ss") & ": " & ErrMsg & vbcrlf, True)
				Err.Add(ErrMsg)
			End If
		End Try
		
		fileSystem.WriteAllText(logFile, DateTime.Now.ToString("yyyy-MM-dd HH:mm:ss") & ": OEORDD Error Count " & MySession.Errors.Count & vbcrlf, True)
		
		If MySession.Errors.Count > 0 Then
			Dim Warn As String
			For index As Integer = 0 To MySession.Errors.Count - 1
				Warn = "Warning: " & MySession.Errors.Item(index).ToString()
				
				Warning.Add(Warn)
				fileSystem.WriteAllText(logFile, DateTime.Now.ToString("yyyy-MM-dd HH:mm:ss") & ": " & Warn & vbcrlf, True)
			Next
		End If
		
		If Err.Count > 0 Then
			Msg.Add("Fail")
		Else
			Msg.Add("Success")
		End If
			
		result.Add(Msg)
		result.Add(Warning)
		result.Add(Err)
		
		fileSystem.WriteAllText(logFile, DateTime.Now.ToString("yyyy-MM-dd HH:mm:ss") & ": Close Session for Database " & iDatabase & vbcrlf, True)
		MySession.Close()
		
		Return result
	End Function
	
End Class
