<%@ Page Title="" Language="C#"  AutoEventWireup="true" CodeBehind="Default.aspx.cs"  %>

<%@ Register TagPrefix="CR" Namespace="CrystalDecisions.Web" Assembly="CrystalDecisions.Web, Version=10.5.3700.0, Culture=neutral, PublicKeyToken=692fbea5521e1304" %>
<%@ Register TagPrefix="CR" Namespace="CrystalDecisions.Web" Assembly="CrystalDecisions.Shared, Version=10.5.3700.0, Culture=neutral, PublicKeyToken=692fbea5521e1304" %>
<%@ Register TagPrefix="CR" Namespace="CrystalDecisions.Web" Assembly="CrystalDecisions.CrystalReports.Engine, Version=10.5.3700.0, Culture=neutral, PublicKeyToken=692fbea5521e1304" %>

<%

    string Pic_Path = HttpContext.Current.Server.MapPath("Sign.jpg");
	using (System.IO.FileStream fs = new System.IO.FileStream(Pic_Path, System.IO.FileMode.Create))
	{
		using (System.IO.BinaryWriter bw = new System.IO.BinaryWriter(fs))
		{
			byte[] data = Convert.FromBase64String(Request.Form["imageData"]);
			
			string SOID = Request.Form["SOID"];
			System.Data.SqlClient.SqlConnection con = new System.Data.SqlClient.SqlConnection("server=ePRPortal\\sqlexpress;uid=sa;pwd=C0mptrac;database=CRM");
			con.Open();
			System.Data.SqlClient.SqlCommand cmd = con.CreateCommand();
			
			cmd.CommandText = "Select 1 from purchasereq Where preq_purchasereqid=" + SOID;
			System.Data.SqlClient.SqlDataReader dr = cmd.ExecuteReader();
			
			if (dr.Read())
			{
				cmd.CommandText = "Update purchasereq SET preq_sign=@img Where preq_purchasereqid=" + SOID ;
			}
			dr.Close();
			cmd.Parameters.AddWithValue("img", data);
			cmd.ExecuteNonQuery();
			
			
			bw.Write(data);
			bw.Close();
		}
	}
%>