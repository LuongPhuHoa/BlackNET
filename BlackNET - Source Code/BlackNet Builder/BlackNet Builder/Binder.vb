Public Class Binder

    Private Sub FormSkin1_Click(sender As Object, e As EventArgs) Handles FormSkin1.Click

    End Sub

    Private Sub Binder_DragDrop(sender As Object, e As DragEventArgs) Handles Me.DragDrop
        Dim files() As String = e.Data.GetData(DataFormats.FileDrop)
        For Each path In files
            FlatTextBox1.Text = path
        Next
    End Sub

    Private Sub Binder_DragEnter(sender As Object, e As DragEventArgs) Handles Me.DragEnter
        If e.Data.GetDataPresent(DataFormats.FileDrop) Then
            e.Effect = DragDropEffects.Copy
        End If
    End Sub

    Private Sub FlatButton2_Click(sender As Object, e As EventArgs) Handles FlatButton2.Click
        Dim ofd As New OpenFileDialog
        With ofd
            .Title = "Please select a file to bind"
            .InitialDirectory = Application.StartupPath
            .DefaultExt = "Any *.* | *.*"
            If .ShowDialog = Windows.Forms.DialogResult.OK Then
                FlatTextBox1.Text = ofd.FileName
            End If
        End With
    End Sub

    Private Sub FlatButton1_Click(sender As Object, e As EventArgs) Handles FlatButton1.Click
        Form1.BinderPath = FlatTextBox1.Text
        Form1.dropPath = FlatComboBox1.SelectedText.ToString
        Form1.dropName = FlatTextBox2.Text
        Form1.sleep = FlatTextBox3.Text
        MessageBox.Show("Binder settings has been saved", "Done !", MessageBoxButtons.OK, MessageBoxIcon.Information)
    End Sub

    Private Sub FormSkin1_DragDrop(sender As Object, e As DragEventArgs) Handles FormSkin1.DragDrop
        Dim files() As String = e.Data.GetData(DataFormats.FileDrop)
        For Each path In files
            FlatTextBox1.Text = path
        Next
    End Sub

    Private Sub FormSkin1_DragEnter(sender As Object, e As DragEventArgs) Handles FormSkin1.DragEnter
        If e.Data.GetDataPresent(DataFormats.FileDrop) Then
            e.Effect = DragDropEffects.Copy
        End If
    End Sub
End Class