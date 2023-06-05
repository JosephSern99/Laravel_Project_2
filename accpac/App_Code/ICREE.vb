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
Public Class ICREE

    Inherits System.Web.Services.WebService
    Public mDBLinkCmpRW As AccpacCOMAPI.AccpacDBLink
    Public mDBLinkSysRW As AccpacCOMAPI.AccpacDBLink
    Public MySession As New AccpacCOMAPI.AccpacSession
    Public errAccpac As AccpacCOMAPI.AccpacErrors

    Private ICREE1header As AccpacCOMAPI.AccpacView
    Private ICREE1headerFields As AccpacCOMAPI.AccpacViewFields
	
    Private ICREE1detail1 As AccpacCOMAPI.AccpacView
    Private ICREE1detail1Fields As AccpacCOMAPI.AccpacViewFields
	
    Private ICREE1detail2 As AccpacCOMAPI.AccpacView
    Private ICREE1detail2Fields As AccpacCOMAPI.AccpacViewFields
	
    Private ICREE1detail3 As AccpacCOMAPI.AccpacView
    Private ICREE1detail3Fields As AccpacCOMAPI.AccpacViewFields
	
    Private ICREE1detail4 As AccpacCOMAPI.AccpacView
    Private ICREE1detail4Fields As AccpacCOMAPI.AccpacViewFields
	
    Private ICREE1detail5 As AccpacCOMAPI.AccpacView
    Private ICREE1detail5Fields As AccpacCOMAPI.AccpacViewFields
	
    Private viewICHeader As AccpacDataSrc.AccpacDataSource
    Public ICNumber As String

    Public Function OpenAccpacTable() As Boolean

        Dim ComposeArray(100) As AccpacCOMAPI.AccpacView

        mDBLinkCmpRW.OpenView("IC0590", ICREE1header)
        mDBLinkCmpRW.OpenView("IC0580", ICREE1detail1)
        mDBLinkCmpRW.OpenView("IC0595", ICREE1detail2)
        mDBLinkCmpRW.OpenView("IC0585", ICREE1detail3)
        mDBLinkCmpRW.OpenView("IC0582", ICREE1detail4)
        mDBLinkCmpRW.OpenView("IC0587", ICREE1detail5)

        ICREE1headerFields = ICREE1header.Fields
        ICREE1detail1Fields = ICREE1detail1.Fields
        ICREE1detail2Fields = ICREE1detail2.Fields
        ICREE1detail3Fields = ICREE1detail3.Fields
        ICREE1detail4Fields = ICREE1detail4.Fields
        ICREE1detail5Fields = ICREE1detail5.Fields

		ReDim ComposeArray(100)
		ComposeArray(0) = ICREE1detail1
        ComposeArray(1) = ICREE1detail2
		ICREE1header.Compose(ComposeArray)
		
		ReDim ComposeArray(100)
        ComposeArray(0) = ICREE1header
		ComposeArray(1) = Nothing
		ComposeArray(2) = Nothing
		ComposeArray(3) = Nothing
		ComposeArray(4) = Nothing
		ComposeArray(5) = Nothing
		ComposeArray(6) = ICREE1detail3
		ComposeArray(7) = ICREE1detail5
		ComposeArray(8) = ICREE1detail4
		ICREE1detail1.Compose(ComposeArray)
		
		ReDim ComposeArray(100)
		ComposeArray(0) = ICREE1header
		ICREE1detail2.Compose(ComposeArray)
		
		ReDim ComposeArray(100)
		ComposeArray(0) = ICREE1detail1
		ICREE1detail3.Compose(ComposeArray)
		
		ReDim ComposeArray(100)
		ComposeArray(0) = ICREE1detail1
		ICREE1detail4.Compose(ComposeArray)
		
		ReDim ComposeArray(100)
		ComposeArray(0) = ICREE1detail1
		ICREE1detail5.Compose(ComposeArray)

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
		
		fileSystem.WriteAllText(logFile, DateTime.Now.ToString("yyyy-MM-dd HH:mm:ss") & ": Open Session for User '" & User & "', Password '" & Password & "'" & vbcrlf, True)
		
        'Company = System.Configuration.ConfigurationManager.AppSettings("Company").ToString

        MySession.Init("", "XY", "XY1000", "62A") '*** Session Initialize
        MySession.Open("ADMIN", "ADMIN", Database, Now.Date, 0, "") '*** Opening Session 

        mDBLinkCmpRW = (MySession.OpenDBLink(AccpacCOMAPI.tagDBLinkTypeEnum.DBLINK_COMPANY, AccpacCOMAPI.tagDBLinkFlagsEnum.DBLINK_FLG_READWRITE))
        mDBLinkSysRW = (MySession.OpenDBLink(AccpacCOMAPI.tagDBLinkTypeEnum.DBLINK_SYSTEM, AccpacCOMAPI.tagDBLinkFlagsEnum.DBLINK_FLG_READWRITE))
        '    OpenAccpacSession = True
        Return MySession.CompanyName
    End Function
	
	<WebMethod()> _
	Public Function ICREEH_Post(ByVal iDatabase As String, ByVal RECPDESC As String, ByVal RECPDATE As String, ByVal DATEBUS As String, ByVal VENDNUMBER As String, ByVal PONUM As String, ByVal REFERENCE As String, _
		ByVal ITEMNO As String, ByVal LOCATION As String, ByVal RECPQTY As String, ByVal COMMENTS As String) _
		As List(Of List(Of String))
		Dim today As String = DateTime.Now.ToString("yyyyMMddHHmmss")
		Dim filePath As String = AppDomain.CurrentDomain.BaseDirectory & "\logs"
		Dim logFile As String = filePath.ToString & "\" & today & "_" & iDatabase & "_ICREEH_Log.txt"
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
			fileSystem.WriteAllText(logFile, DateTime.Now.ToString("yyyy-MM-dd HH:mm:ss") & ": Start Posting ICREEH For " & iDatabase & vbcrlf, True)
			
			With ICREE1header
				.FilterSelect("(DELETED = 0)", True, 2, 0)
				.Order = 2
				.Order = 0
				.Browse("", 1)
				.Fetch()
				.RecordCreate(False)
				.Fields.Item("RECPTYPE").Value = "2"
				.Fields.Item("SEQUENCENO").PutWithoutVerification("0")
				.Init
				.Order = 3
				ICREE1detail1.RecordClear
				ICREE1detail5.RecordClear
				.Fields.Item("PROCESSCMD").PutWithoutVerification("1")
				.Fields.Item("RECPDESC").PutWithoutVerification(RECPDESC) 'Description
				.Process
				.Fields.Item("RECPDATE").Value = RECPDATE ' Internal Usage Date
				.Fields.Item("DATEBUS").Value = DATEBUS ' Posting Date
				.Fields.Item("VENDNUMBER").Value = VENDNUMBER ' Vendor Number
				.Fields.Item("PROCESSCMD").PutWithoutVerification("1")
				.Fields.Item("PONUM").PutWithoutVerification(PONUM)
				.Fields.Item("REFERENCE").PutWithoutVerification(REFERENCE)
				.Fields.Item("STATUS").PutWithoutVerification("1")
				
				If ITEMNO.indexOf(",") > -1 Then
					Dim itemArr As String() = ITEMNO.Split(",")
					Dim LocationArr As String() = LOCATION.Split(",")
					Dim recpQtyArr As String() = RECPQTY.Split(",")
					Dim commentsArr As String() = COMMENTS.Split(",")
					
					For i As Integer = 0 To itemArr.Length - 1
						ICREE1detail1.RecordCreate(0)
						With ICREE1detail1
							.Fields.Item("ITEMNO").Value = itemArr(i)
							.Fields.Item("PROCESSCMD").PutWithoutVerification("1")
							.Process
							.Fields.Item("LOCATION").Value = LocationArr(i)
							.Fields.Item("RECPQTY").Value = recpQtyArr(i)
							.Fields.Item("COMMENTS").Value = commentsArr(i)
							.Fields.Item("CHKBELZERO").PutWithoutVerification("1")
							.Process
							.Insert
						End With
					Next
				Else
					ICREE1detail1.RecordCreate(0)
					With ICREE1detail1
						.Fields.Item("ITEMNO").Value = ITEMNO
						.Fields.Item("PROCESSCMD").PutWithoutVerification("1")
						.Process
						.Fields.Item("LOCATION").Value = LOCATION
						.Fields.Item("RECPQTY").Value = RECPQTY
						.Fields.Item("COMMENTS").Value = COMMENTS
						.Fields.Item("CHKBELZERO").PutWithoutVerification("1")
						.Process
						.Insert
					End With
				End If
				
				.Insert
			End With
			
			ICREE1detail1.RecordClear
			ICREE1detail5.RecordClear
			
			Ref.Add(ICREE1header.Fields.Item("RECPNUMBER").Value)
			fileSystem.WriteAllText(logFile, DateTime.Now.ToString("yyyy-MM-dd HH:mm:ss") & ": End Posting ICREEH " & vbcrlf, True)
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
	Public Function ICREED_Post(ByVal iDatabase As String, ByVal REC As String) _
		As List(Of List(Of String))
		
		Dim today As String = DateTime.Now.ToString("yyyyMMdd")
		
		Dim filePath As String = AppDomain.CurrentDomain.BaseDirectory & "\logs"
		Dim logFile As String = filePath.ToString & "\" & today & "_" & REC & "_ICREED_Log.txt"
		DIm fileSystem = My.Computer.FileSystem 
		
		fileSystem.WriteAllText(logFile, DateTime.Now.ToString("yyyy-MM-dd HH:mm:ss") & ": Open Session for Database " & iDatabase & vbcrlf, True)
		
		Call OpenAccpacSession(iDatabase)
        Call OpenAccpacTable()
		
		Dim result As New List(Of List(Of String))
		Dim Msg As New List(Of String)
		Dim Warning As New List(Of String)
		Dim Err As New List(Of String)
		
		Try
			fileSystem.WriteAllText(logFile, DateTime.Now.ToString("yyyy-MM-dd HH:mm:ss") & ": Start Posting ICREED " & vbcrlf, True)
			fileSystem.WriteAllText(logFile, DateTime.Now.ToString("yyyy-MM-dd HH:mm:ss") & ": Reading " & REC & vbcrlf, True)
			
			ICREE1header.FilterSelect("(DELETED = 0)", True, 2, 0)
			'ICREE1header.Order = 2
			'ICREE1header.Order = 0
			ICREE1header.Fields.Item("RECPTYPE").Value = "1"  
			ICREE1header.Init
			'ICREE1header.Order = 2
			'ICREE1header.Fields.Item("SEQUENCENO").PutWithoutVerification("0")
			ICREE1header.Fields.Item("RECPNUMBER").Value = REC
			ICREE1header.Init
			'ICREE1header.Fields.Item("PROCESSCMD").PutWithoutVerification("1")
			ICREE1header.Process
			ICREE1header.Read
			fileSystem.WriteAllText(logFile, DateTime.Now.ToString("yyyy-MM-dd HH:mm:ss") & ": O " & ICREE1header.Fields.Item("RECPNUMBER").Value & vbcrlf, True)
			
			ICREE1detail1.RecordClear
				REM With ICREE1detail1
					REM .Browse("", 0)
					REM .GoBottom()
					REM .RecordCreate(0)
					REM .Fields.Item("ITEMNO").Value = "0000"
					REM .Fields.Item("PROCESSCMD").PutWithoutVerification("1")
					REM .Process
					REM .Fields.Item("LOCATION").Value = "1"
					REM .Fields.Item("RECPQTY").Value = "2.00"
					REM .Fields.Item("UNITCOST").Value = "2.00"
					REM .Fields.Item("LINENO").PutWithoutVerification("-1")
					REM .Fields.Item("COMMENTS").PutWithoutVerification("test")
					REM .Fields.Item("CHKBELZERO").PutWithoutVerification("1")
					REM .Process
					REM .Insert
				REM End With
			ICREE1header.Update
			
			fileSystem.WriteAllText(logFile, DateTime.Now.ToString("yyyy-MM-dd HH:mm:ss") & ": End Posting ICREED " & vbcrlf, True)
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
		
		fileSystem.WriteAllText(logFile, DateTime.Now.ToString("yyyy-MM-dd HH:mm:ss") & ": ICREED Error Count " & MySession.Errors.Count & vbcrlf, True)
		
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
