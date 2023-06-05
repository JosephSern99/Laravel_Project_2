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
Public Class ICICE

    Inherits System.Web.Services.WebService
    Public mDBLinkCmpRW As AccpacCOMAPI.AccpacDBLink
    Public mDBLinkSysRW As AccpacCOMAPI.AccpacDBLink
    Public MySession As New AccpacCOMAPI.AccpacSession
    Public errAccpac As AccpacCOMAPI.AccpacErrors

    Private ICICE1header As AccpacCOMAPI.AccpacView
    Private ICICE1headerFields As AccpacCOMAPI.AccpacViewFields
    Private ICICE1detail1 As AccpacCOMAPI.AccpacView
    Private ICICE1detail1Fields As AccpacCOMAPI.AccpacViewFields
    Private ICICE1detail2 As AccpacCOMAPI.AccpacView
    Private ICICE1detail2Fields As AccpacCOMAPI.AccpacViewFields
    Private ICICE1detail3 As AccpacCOMAPI.AccpacView
    Private ICICE1detail3Fields As AccpacCOMAPI.AccpacViewFields
    Private ICICE1detail4 As AccpacCOMAPI.AccpacView
    Private ICICE1detail4Fields As AccpacCOMAPI.AccpacViewFields
    Private ICICE1detail5 As AccpacCOMAPI.AccpacView
    Private ICICE1detail5Fields As AccpacCOMAPI.AccpacViewFields
	
    Private viewICHeader As AccpacDataSrc.AccpacDataSource
    Public ICNumber As String

    Public Function OpenAccpacTable() As Boolean

        Dim ComposeArray(100) As AccpacCOMAPI.AccpacView

        mDBLinkCmpRW.OpenView("IC0288", ICICE1header)
        mDBLinkCmpRW.OpenView("IC0286", ICICE1detail1)
        mDBLinkCmpRW.OpenView("IC0289", ICICE1detail2)
        mDBLinkCmpRW.OpenView("IC0287", ICICE1detail3)
        mDBLinkCmpRW.OpenView("IC0282", ICICE1detail4)
        mDBLinkCmpRW.OpenView("IC0284", ICICE1detail5)

        ICICE1headerFields = ICICE1header.Fields
        ICICE1detail1Fields = ICICE1detail1.Fields
        ICICE1detail2Fields = ICICE1detail2.Fields
        ICICE1detail3Fields = ICICE1detail3.Fields
        ICICE1detail4Fields = ICICE1detail4.Fields
        ICICE1detail5Fields = ICICE1detail5.Fields

		ReDim ComposeArray(100)
		ComposeArray(0) = ICICE1detail1
        ComposeArray(1) = ICICE1detail2
		ICICE1header.Compose(ComposeArray)
		
		ReDim ComposeArray(100)
        ComposeArray(0) = ICICE1header
		ComposeArray(1) = ICICE1detail3
		ComposeArray(2) = ICICE1detail5
		ComposeArray(3) = Nothing
		ComposeArray(4) = Nothing
		ComposeArray(5) = Nothing
		ComposeArray(6) = Nothing
		ComposeArray(7) = Nothing
		ComposeArray(8) = ICICE1detail4
		ICICE1detail1.Compose(ComposeArray)
		
		ReDim ComposeArray(100)
		ComposeArray(0) = ICICE1header
		ICICE1detail2.Compose(ComposeArray)
		
		ReDim ComposeArray(100)
		ComposeArray(0) = ICICE1detail1
		ICICE1detail3.Compose(ComposeArray)
		
		ReDim ComposeArray(100)
		ComposeArray(0) = ICICE1detail1
		ICICE1detail4.Compose(ComposeArray)
		
		ReDim ComposeArray(100)
		ComposeArray(0) = ICICE1detail1
		ICICE1detail5.Compose(ComposeArray)

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
	Public Function ICICEH_Post(ByVal iDatabase As String, ByVal HDRDESC As String, ByVal TRANSDATE As String, ByVal DATEBUS As String, ByVal EMPLOYEENO As String, ByVal REFERENCE As String, _
		ByVal ITEMNO As String, ByVal LOCATION As String, ByVal QUANTITY As Decimal, ByVal COMMENTS As String) _
		As List(Of List(Of String))
		Dim today As String = DateTime.Now.ToString("yyyyMMddHHmmss")
		
		Dim filePath As String = AppDomain.CurrentDomain.BaseDirectory & "\logs"
		Dim logFile As String = filePath.ToString & "\" & today & "_" & iDatabase & "_ICICEH_Log.txt"
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
			fileSystem.WriteAllText(logFile, DateTime.Now.ToString("yyyy-MM-dd HH:mm:ss") & ": Start Posting ICICEH For " & iDatabase & vbcrlf, True)
			
			With ICICE1header
				.FilterSelect("(DELETED = 0)", True, 3, 0)
				.Order = 3
				.Order = 0
				.Fields.Item("SEQUENCENO").PutWithoutVerification("0")
				.Init
				.Order = 3
				ICICE1detail1.RecordClear
				ICICE1detail5.RecordClear
				.Fields.Item("PROCESSCMD").PutWithoutVerification("1")
				.Fields.Item("HDRDESC").PutWithoutVerification(HDRDESC) 'Description
				.Process
				
				ICICE1detail1.RecordCreate(0)
				With ICICE1detail1
					.Fields.Item("ITEMNO").Value = ITEMNO
					.Fields.Item("PROCESSCMD").PutWithoutVerification("1")
					.Process
					.Fields.Item("LOCATION").Value = LOCATION
					.Fields.Item("COMMENTS").Value = COMMENTS
					.Process
					.Fields.Item("QUANTITY").Value = QUANTITY
					.Fields.Item("FUNCTION").Value = "100"
					'.Process
					.Fields.Item("PROCESSCMD").PutWithoutVerification("1") 'equivalent to Process, without verify
					.Insert
				End With
				.Fields.Item("TRANSDATE").Value = TRANSDATE ' Internal Usage Date
				.Fields.Item("DATEBUS").Value = DATEBUS ' Posting Date
				.Fields.Item("REFERENCE").PutWithoutVerification(REFERENCE) 'Reference
				.Fields.Item("EMPLOYEENO").PutWithoutVerification(EMPLOYEENO) 'Used By
				.Fields.Item("STATUS").PutWithoutVerification("1")
				.Insert
			End With
			
			ICICE1detail1.RecordClear
			ICICE1detail5.RecordClear
			
			Ref.Add(ICICE1header.Fields.Item("DOCNUM").Value)
			fileSystem.WriteAllText(logFile, DateTime.Now.ToString("yyyy-MM-dd HH:mm:ss") & ": End Posting ICICEH " & vbcrlf, True)
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
	Public Function ICICED_Post(ByVal iDatabase As String, ByVal DOCNUM As String, ByVal ITEMNO As String, ByVal LOCATION As String, ByVal QUANTITY As Decimal, ByVal COMMENTS As String) _
		As List(Of List(Of String))
		
		Dim today As String = DateTime.Now.ToString("yyyyMMdd")
		
		Dim filePath As String = AppDomain.CurrentDomain.BaseDirectory & "\logs"
		Dim logFile As String = filePath.ToString & "\" & today & "_" & DOCNUM & "_ICICED_Log.txt"
		DIm fileSystem = My.Computer.FileSystem 
		
		fileSystem.WriteAllText(logFile, DateTime.Now.ToString("yyyy-MM-dd HH:mm:ss") & ": Open Session for Database " & iDatabase & vbcrlf, True)
		
		Call OpenAccpacSession(iDatabase)
        Call OpenAccpacTable()
		
		Dim result As New List(Of List(Of String))
		Dim Msg As New List(Of String)
		Dim Warning As New List(Of String)
		Dim Err As New List(Of String)
		
		Try
			fileSystem.WriteAllText(logFile, DateTime.Now.ToString("yyyy-MM-dd HH:mm:ss") & ": Start Posting ICICED " & vbcrlf, True)
			fileSystem.WriteAllText(logFile, DateTime.Now.ToString("yyyy-MM-dd HH:mm:ss") & ": Reading " & DOCNUM & vbcrlf, True)
			
			With ICICE1header
				.FilterSelect("(DELETED = 0)", True, 3, 0)
				.Order = 3
				.Order = 0
				.Fields.Item("SEQUENCENO").PutWithoutVerification("0")
				.Init
				.Order = 3
				ICICE1detail1.RecordClear
				ICICE1detail5.RecordClear
				.Fields.Item("DOCNUM").Value = DOCNUM
				.Read
			fileSystem.WriteAllText(logFile, DateTime.Now.ToString("yyyy-MM-dd HH:mm:ss") & ": Reading " & .RecordNumber & vbcrlf, True)
				
				With ICICE1detail1
					.GoBottom()
					.RecordCreate(0)
					.Fields.Item("LINENO").PutWithoutVerification("-1")
					.Fields.Item("ITEMNO").Value = ITEMNO
					.Fields.Item("PROCESSCMD").PutWithoutVerification("1")
					.Process
					.Fields.Item("LOCATION").Value = LOCATION
					.Fields.Item("QUANTITY").Value = QUANTITY
					.Fields.Item("COMMENTS").Value = COMMENTS
					.Fields.Item("FUNCTION").Value = "100"
					.Process
					.Insert
				End With
				.Update
			End With
			
			fileSystem.WriteAllText(logFile, DateTime.Now.ToString("yyyy-MM-dd HH:mm:ss") & ": End Posting ICICED " & vbcrlf, True)
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
		
		fileSystem.WriteAllText(logFile, DateTime.Now.ToString("yyyy-MM-dd HH:mm:ss") & ": ICICED Error Count " & MySession.Errors.Count & vbcrlf, True)
		
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
