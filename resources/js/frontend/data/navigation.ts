import route from "ziggy";
import {
  NavItemType,
} from "@blog/components/Navigation/NavigationItem";
import ncNanoId from "@blog/utils/ncNanoId";

const blogId = () => route().current()?.includes('blog') ? ncNanoId() : '';

export const NAVIGATION_DEMO: NavItemType[] = [
  {
    id: blogId(),
    href: route("home"),
    name: "Find a Pest Controller",
    current: true,
  },
  {
    id: blogId(),
    href: route("about"),
    name: "About Us",
    current: false,
  },
  {
    id: blogId(),
    href: route("pests"),
    name: "A-Z of Pests",
    current: false,
  },
  {
    id: blogId(),
    href: route("blog"),
    name: "Blog",
    current: false,
  }
];

export const FOOTER_DEMO = [
    'Find a Pest Controller',
    'About Us',
    'A-Z of Pests',
    'Blog',
]
