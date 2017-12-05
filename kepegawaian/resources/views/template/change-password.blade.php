<div class="header-content">
  <ul id="pintasan">
    <a href="/"><li class="home">Home</li><span>|</span></a>
    <a href="#"><li class="active-history">Ubah Password</li></a>
  </ul>
</div>
<div id="content">
  <div class="headerwrap">
    Ubah Password
  </div>
  <div class="contentwrap">
    <form id="serialize">
      <table style="min-width: 400px;width:50%">
        <tr>
          <th style="background-color:#9a98f5;color:#000;width:40%">Password Lama</th>
          <td>
            <input type="password" name="lastpassword" id="lastpassword">
          </td>
        </tr>
        <tr>
          <th style="background-color:#9a98f5;color:#000;width:40%">Password Baru</th>
          <td>
            <input type="password" name="newpassword" id="newpassword">
          </td>
        </tr>
        <tr>
          <th style="background-color:#9a98f5;color:#000;width:40%">Ulangi Password Baru</th>
          <td>
            <input type="password" name="repassword" id="repassword" onkeypress="last_form(event,'simpan')">
          </td>
        </tr>
      </table>
      <br>
      <button type="button" id="simpan" onclick="save_new_password()" class="blue" name="button">Simpan</button>
      <button type="reset" class="red" name="button">Batal</button>
    </form>
  </div>
</div>
