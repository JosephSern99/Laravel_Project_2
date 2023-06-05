using System;
using System.Web;
using System.IO;
using System.Web.Script.Services;
using System.Web.Services;

namespace home
{
    public partial class Default : System.Web.UI.Page
    {
        protected void Page_Load(object sender, EventArgs e)
        {
			/*Response.Write(HttpContext.Current.Server.MapPath("MyPicture.png"));
           string Pic_Path = HttpContext.Current.Server.MapPath("MyPicture.png");
			using (FileStream fs = new FileStream(Pic_Path, FileMode.Create))
			{
				using (BinaryWriter bw = new BinaryWriter(fs))
				{
					byte[] data = Convert.FromBase64String(imageData);
					bw.Write(data);
					bw.Close();
				}
			}*/
			Response.Write("abcd");
        }
    }
}