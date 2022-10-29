#!/usr/bin/env ts-node

import {fetch} from "fetch-h2";

// Determine whether the sentiment of text is positive

// Use a web service

async function isPositive(text: string): Promise<boolean> {
    const response = await fetch("https://text-processing.com/api/sentiment/", {
        method: "POST",
        body: `text=${text}`,
        headers: {
            "Content-Type": "application/x-www-form-urlencoded",
        },
    });
    const json = await response.json();
    return json.label === "pos";
}
