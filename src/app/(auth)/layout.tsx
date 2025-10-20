import Image from "next/image";

export default function AuthLayout({
  children,
}: {
  children: React.ReactNode;
}) {
  return (
    <div className="flex min-h-screen w-full items-center justify-center bg-background">
        <div className="w-full max-w-md p-8">
            {children}
        </div>
    </div>
  );
}
