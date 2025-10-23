"use client";

import { useEffect, useState } from "react";
import { Avatar, AvatarFallback, AvatarImage } from "@/components/ui/avatar";
import { Button } from "@/components/ui/button";
import {
  DropdownMenu,
  DropdownMenuContent,
  DropdownMenuGroup,
  DropdownMenuItem,
  DropdownMenuLabel,
  DropdownMenuSeparator,
  DropdownMenuTrigger,
} from "@/components/ui/dropdown-menu";
import { PlaceHolderImages } from "@/lib/placeholder-images";
import Link from "next/link";
import type { UserRole } from "@/lib/types";

export function UserNav() {
  const [userName, setUserName] = useState<string | null>(null);
  const [userEmail, setUserEmail] = useState<string | null>(null);
  const [userAvatarId, setUserAvatarId] = useState<string | null>(null);

  useEffect(() => {
    setUserName(localStorage.getItem("userName"));
    setUserEmail(localStorage.getItem("userEmail"));
    setUserAvatarId(localStorage.getItem("userAvatar"));
  }, []);

  const avatarData = PlaceHolderImages.find(p => p.id === userAvatarId);
  const fallback = userName ? userName.charAt(0).toUpperCase() + (userName.split(' ')[1] ? userName.split(' ')[1].charAt(0).toUpperCase() : '') : "U";

  return (
    <DropdownMenu>
      <DropdownMenuTrigger asChild>
        <Button variant="ghost" className="relative h-8 w-8 rounded-full">
          <Avatar className="h-9 w-9">
             <AvatarImage src={avatarData?.imageUrl} alt={userName || ""} data-ai-hint={avatarData?.imageHint}/>
            <AvatarFallback>{fallback}</AvatarFallback>
          </Avatar>
        </Button>
      </DropdownMenuTrigger>
      <DropdownMenuContent className="w-56" align="end" forceMount>
        <DropdownMenuLabel className="font-normal">
          <div className="flex flex-col space-y-1">
            <p className="text-sm font-medium leading-none">{userName || "User"}</p>
            <p className="text-xs leading-none text-muted-foreground">
              {userEmail || "user@example.com"}
            </p>
          </div>
        </DropdownMenuLabel>
        <DropdownMenuSeparator />
        <DropdownMenuGroup>
          <DropdownMenuItem>Profile</DropdownMenuItem>
          <DropdownMenuItem>Billing</DropdownMenuItem>
          <DropdownMenuItem>Settings</DropdownMenuItem>
        </DropdownMenuGroup>
        <DropdownMenuSeparator />
        <DropdownMenuItem asChild>
          <Link href="/login">Log out</Link>
        </DropdownMenuItem>
      </DropdownMenuContent>
    </DropdownMenu>
  );
}
