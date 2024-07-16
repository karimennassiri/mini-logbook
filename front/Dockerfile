# Use an official Debian as a parent image
FROM debian:latest

# Set the working directory inside the container
WORKDIR /app

# Copy the rest of the application into the container
COPY . .

# Remove dependencies & packages lock 
RUN rm -f package-lock.json && \
    rm -rf node_modules

# Install dependencies
RUN apt-get update && apt-get install -y \
    curl \
    build-essential \
    unzip \
    && rm -rf /var/lib/apt/lists/*

# Install Node.js
RUN curl -fsSL https://deb.nodesource.com/setup_16.x | bash - \
    && apt-get install -y nodejs

# Install Bun
RUN curl -fsSL https://bun.sh/install | bash \
    && mv /root/.bun/bin/bun /usr/local/bin/

# Install application dependencies and build the project
RUN bun install && bun run build

# Expose the port the application will use
EXPOSE 5173

# Set the command to start the application
CMD ["bun", "dev","--host"]
