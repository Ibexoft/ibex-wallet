using Microsoft.Owin;
using Owin;

[assembly: OwinStartupAttribute(typeof(aspnet.mvc.Startup))]
namespace aspnet.mvc
{
    public partial class Startup
    {
        public void Configuration(IAppBuilder app)
        {
            ConfigureAuth(app);
        }
    }
}
